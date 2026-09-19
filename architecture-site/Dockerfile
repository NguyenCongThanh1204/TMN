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
# 2. CÀI NODE.JS 20 + NPM
# ============================================================

RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && node --version \
    && npm --version \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# ============================================================
# 3. CÀI COMPOSER
# ============================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# ============================================================
# 4. COPY SOURCE CODE
# ============================================================

WORKDIR /var/www/html

COPY . .


# ============================================================
# 5. BUILD FRONTEND VITE
# ============================================================
#
# Laravel sử dụng:
#
# @vite([
#     'resources/css/app.css',
#     'resources/js/app.js'
# ])
#
# Vì vậy production phải có:
#
# public/build/manifest.json
#
# npm run build sẽ tạo thư mục này.
#

RUN if [ -f package-lock.json ]; then \
        npm ci; \
    else \
        npm install; \
    fi \
    && npm run build \
    && test -f public/build/manifest.json \
    && echo "Vite build OK: public/build/manifest.json exists"


# ============================================================
# 6. CÀI DEPENDENCY LARAVEL
# ============================================================

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# ============================================================
# 7. TẠO SQLITE + THƯ MỤC LARAVEL
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
# 8. KHÔNG TẠO .ENV
# ============================================================
#
# APP_ENV
# APP_DEBUG
# APP_KEY
# APP_URL
#
# được Render cung cấp bằng Environment Variables.
#
# DB_CONNECTION và DB_DATABASE có ENV mặc định ở đầu Dockerfile
# để quá trình build/seed sử dụng SQLite.
#
# KHÔNG tạo .env trong Docker image.


# ============================================================
# 9. MIGRATE + SEED DATABASE
# ============================================================
#
# DatabaseSeeder chạy bằng SQLite.
#
# DB_CONNECTION=sqlite
# DB_DATABASE=/var/www/html/database/database.sqlite
#
# đã được khai báo ở ENV phía trên.
#

USER www-data

RUN php artisan migrate:fresh --seed --force

USER root


# ============================================================
# 10. CLEAR LARAVEL CACHE
# ============================================================

RUN php artisan optimize:clear


# ============================================================
# 11. CẤU HÌNH PHP-FPM
# ============================================================
#
# PHP-FPM:
# 127.0.0.1:9000
#
# Quan trọng:
# clear_env = no
#
# để PHP-FPM không xóa Environment Variables của Render.
#

RUN sed -i \
    's#^listen = .*#listen = 127.0.0.1:9000#' \
    /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && sed -i \
    's/^user = .*/user = www-data/' \
    /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && sed -i \
    's/^group = .*/group = www-data/' \
    /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && sed -i \
    '/^[;[:space:]]*clear_env[[:space:]]*=.*/d' \
    /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && echo 'clear_env = no' >> \
    /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf


# ============================================================
# 12. KIỂM TRA PHP-FPM CONFIG
# ============================================================

RUN echo "===== PHP-FPM CONFIG =====" \
    && grep -E '^(listen|user|group|clear_env)' \
    /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf


# ============================================================
# 13. CẤU HÌNH NGINX
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


    # ========================================================
    # Laravel
    # ========================================================

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }


    # ========================================================
    # PHP-FPM
    # ========================================================

    location ~ \.php$ {
        include fastcgi_params;

        fastcgi_pass 127.0.0.1:9000;

        fastcgi_index index.php;

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_param PATH_INFO $fastcgi_path_info;
    }


    # ========================================================
    # Block hidden files
    # ========================================================

    location ~ /\.ht {
        deny all;
    }


    # ========================================================
    # Static assets
    # ========================================================

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|webp|woff|woff2|ttf)$ {
        expires 7d;

        add_header Cache-Control "public, max-age=604800";

        try_files $uri =404;
    }
}

NGINX


# ============================================================
# 14. ENABLE NGINX CONFIG
# ============================================================

RUN ln -s /etc/nginx/sites-available/default \
    /etc/nginx/sites-enabled/default


# ============================================================
# 15. KIỂM TRA NGINX CONFIG
# ============================================================

RUN nginx -t


# ============================================================
# 16. CẤU HÌNH SUPERVISOR
# ============================================================

RUN cat > /etc/supervisor/conf.d/supervisord.conf <<'SUPERVISOR'

[supervisord]
nodaemon=true
user=root
logfile=/dev/null
pidfile=/run/supervisord.pid


# ============================================================
# PHP-FPM
# ============================================================

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


# ============================================================
# NGINX
# ============================================================

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
# 17. QUYỀN LẦN CUỐI
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
# 18. PORT RENDER
# ============================================================

EXPOSE 10000


# ============================================================
# 19. START CONTAINER
# ============================================================

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]