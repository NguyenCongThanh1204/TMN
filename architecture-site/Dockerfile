FROM ubuntu:22.04

ARG PHP_VERSION=8.3
ARG NODE_VERSION=20
ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1

# 1. Cài đặt các gói hệ thống, PHP 8.3, Nginx và Supervisor
RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg2 ca-certificates lsb-release apt-transport-https software-properties-common curl git unzip rsync \
    nginx supervisor \
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
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Cài đặt Composer từ image chính thức
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# 3. Cài đặt các dependency của Laravel (Production)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 4. Tạo thư mục, file SQLite, cấp quyền chuẩn xác
RUN mkdir -p database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache /run/php \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html /run/php \
    && chmod -R 775 storage bootstrap/cache database \
    && chmod 664 database/database.sqlite

# Chạy migration và seeder dữ liệu
USER www-data
RUN php artisan migrate:fresh --seed --force
USER root

# Xóa cache cũ
RUN php artisan config:clear && php artisan cache:clear

# 5. Cấu hình Nginx trỏ về cổng TCP 9000 của PHP-FPM
RUN echo 'server { \
    listen 0.0.0.0:10000 default_server; \
    root /var/www/html/public; \
    index index.php index.html; \
    server_name _; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name; \
    } \
    location ~ /\.ht { \
        deny all; \
    } \
}' > /etc/nginx/sites-available/default \
    && rm -f /etc/nginx/sites-enabled/default \
    && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# 6. Ép PHP-FPM chuyển sang lắng nghe TCP Port 127.0.0.1:9000 thay vì dùng Socket
RUN sed -i 's#listen = /run/php/php8.3-fpm.sock#listen = 127.0.0.1:9000#g' /etc/php/8.3/fpm/pool.d/www.conf \
    && sed -i 's/user = www-data/user = www-data/g' /etc/php/8.3/fpm/pool.d/www.conf \
    && sed -i 's/group = www-data/group = www-data/g' /etc/php/8.3/fpm/pool.d/www.conf

# 7. Cấu hình Supervisor chạy song song Nginx và PHP-FPM dưới quyền root
RUN echo '[supervisord]\n\
nodaemon=true\n\
user=root\n\n\
[program:php-fpm]\n\
command=/usr/sbin/php-fpm8.3 -F\n\
autostart=true\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0\n\n\
[program:nginx]\n\
command=nginx -g "daemon off;"\n\
autostart=true\n\
autorestart=true\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n\
stderr_logfile=/dev/stderr\n\
stderr_logfile_maxbytes=0' > /etc/supervisor/conf.d/supervisord.conf

EXPOSE 10000

# Sửa lại dòng lệnh CMD trỏ chính xác vào file conf.d/supervisord.conf
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]