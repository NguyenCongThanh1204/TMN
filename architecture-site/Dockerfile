FROM ubuntu:22.04

ARG PHP_VERSION=8.3
ARG NODE_VERSION=20

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/html/database/database.sqlite

# ============================================================
# 1. CÀI ĐẶT HỆ THỐNG + PHP 8.3 + NGINX + SUPERVISOR
# ============================================================

RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg2 \
    ca-certificates \
    lsb-release \
    apt-transport-https \
    software-properties-common \
    curl \
    git \
    unzip \
    rsync \
    nginx \
    supervisor \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-bcmath \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-sqlite3 \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-opcache \
        php${PHP_VERSION}-intl \
        php${PHP_VERSION}-gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# ============================================================
# 2. CÀI COMPOSER
# ============================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ============================================================
# 3. COPY SOURCE CODE
# ============================================================

WORKDIR /var/www/html

COPY . .


# ============================================================
# 4. CÀI DEPENDENCY LARAVEL
# ============================================================

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# ============================================================
# 5. TẠO SQLITE + THƯ MỤC LARAVEL
# ============================================================

RUN mkdir -p \
        database \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
        /run/php \
    && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html \
    && chown -R www-data:www-data /run/php \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/database \
    && chmod 664 /var/www/html/database/database.sqlite


# ============================================================
# 6. TẠO .ENV CHO SQLITE
# ============================================================
#
# Render vẫn có thể override các biến ENV bằng Environment Variables.
# Nhưng image luôn có cấu hình SQLite mặc định để tránh Laravel
# cố kết nối MySQL nếu Render chưa cấu hình DB.
#



# ============================================================
# 8. MIGRATE + SEED DATABASE
# ============================================================
#
# DatabaseSeeder của bạn đang dùng SQLite.
# Chạy dưới www-data để quyền file database chính xác.
#

USER www-data

RUN php artisan migrate:fresh --seed --force

USER root


# ============================================================
# 9. CLEAR + CACHE LARAVEL
# ============================================================

RUN php artisan optimize:clear


# ============================================================
# 10. CẤU HÌNH PHP-FPM
# ============================================================
#
# PHP-FPM lắng nghe:
# 127.0.0.1:9000
#
# Nginx sẽ forward request PHP sang port này.
#

RUN sed -i \
    's#^listen = .*#listen = 127.0.0.1:9000#' \
    /etc/php/8.3/fpm/pool.d/www.conf \
    && sed -i \
    's/^user = .*/user = www-data/' \
    /etc/php/8.3/fpm/pool.d/www.conf \
    && sed -i \
    's/^group = .*/group = www-data/' \
    /etc/php/8.3/fpm/pool.d/www.conf


# ============================================================
# 11. CẤU HÌNH NGINX
# ============================================================

RUN rm -f /etc/nginx/sites-enabled/default \
    && cat > /etc/nginx/sites-available/default <<'NGINX'
server {
    listen 0.0.0.0:10000 default_server;
    listen [::]:10000 default_server;

    server_name _;

    root /var/www/html/public;

    index index.php index.html;

    client_max_body_size 50M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;

        fastcgi_pass 127.0.0.1:9000;

        fastcgi_index index.php;

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    location ~ /\.ht {
        deny all;
    }

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|webp|woff|woff2|ttf)$ {
        expires 7d;
        add_header Cache-Control "public, max-age=604800";
        try_files $uri =404;
    }
}
NGINX

RUN ln -s /etc/nginx/sites-available/default \
    /etc/nginx/sites-enabled/default


# ============================================================
# 12. KIỂM TRA NGINX CONFIG
# ============================================================

RUN nginx -t


# ============================================================
# 13. CẤU HÌNH SUPERVISOR
# ============================================================
#
# Supervisor chạy:
# - PHP-FPM
# - Nginx
#

RUN cat > /etc/supervisor/conf.d/supervisord.conf <<'SUPERVISOR'
[supervisord]
nodaemon=true
user=root
logfile=/dev/null
pidfile=/run/supervisord.pid

[program:php-fpm]
command=/usr/sbin/php-fpm8.3 -F
directory=/var/www/html
autostart=true
autorestart=true
priority=10
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
stopasgroup=true
killasgroup=true

[program:nginx]
command=/usr/sbin/nginx -g "daemon off;"
directory=/var/www/html
autostart=true
autorestart=true
priority=20
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
stopasgroup=true
killasgroup=true
SUPERVISOR


# ============================================================
# 14. QUYỀN LẦN CUỐI
# ============================================================

RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        /var/www/html/database \
    && chmod -R 775 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        /var/www/html/database


# ============================================================
# 15. PORT RENDER
# ============================================================

EXPOSE 10000


# ============================================================
# 16. START CONTAINER
# ============================================================

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]