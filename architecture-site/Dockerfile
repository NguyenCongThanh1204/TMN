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

# 4. Tạo thư mục, file SQLite, cấp quyền chuẩn xác cho www-data
RUN mkdir -p database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache /run/php \
    && touch database/database.sqlite \
    && chown -R www-data:www-data /var/www/html /run/php \
    && chmod -R 775 storage bootstrap/cache database \
    && chmod 664 database/database.sqlite

# Chạy migration và seeder dữ liệu dưới quyền www-data để file sqlite không bị lệch quyền sở hữu gây lỗi 500
USER www-data
RUN php artisan migrate:fresh --seed --force
USER root

# Xóa cache cũ để làm sạch cấu hình
RUN php artisan config:clear && php artisan cache:clear

# 5. Tự động cấu hình Nginx lắng nghe cổng 10000 và trỏ PHP qua TCP port 9000
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

# 6. Cấu hình Supervisor (Bổ sung user=root để tránh cảnh báo và đảm bảo phân quyền tuyệt đối)
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

# Khởi chạy hệ thống thông qua Supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]