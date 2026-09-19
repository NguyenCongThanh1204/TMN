FROM ubuntu:22.04

ARG PHP_VERSION=8.3
ARG NODE_VERSION=20
ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1

# 1. Cài đặt các gói hệ thống, PHP 8.3, Nginx, Supervisor và các extension cần thiết
RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg2 ca-certificates lsb-release apt-transport-https software-properties-common curl git unzip rsync \
    nginx supervisor \
    && add-apt-repository ppa:ondrej/php \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-bcmath \
        php${PHP_VERSION}-ctype \
        php${PHP_VERSION}-curl \
        php${PHP_VERSION}-dom \
        php${PHP_VERSION}-fileinfo \
        php${PHP_VERSION}-mbstring \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-openssl \
        php${PHP_VERSION}-pdo \
        php${PHP_VERSION}-tokenizer \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-zip \
        php${PHP_VERSION}-opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Cài đặt Composer từ image chính thức
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# 3. Cài đặt các dependency của Laravel (Production)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 4. Tạo và cấp quyền cho các thư mục cache/storage
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# 5. Tự động cấu hình Nginx lắng nghe cổng 10000 dành riêng cho Render
RUN echo 'server { \
    listen 0.0.0.0:10000 default_server; \
    root /var/www/html/public; \
    index index.php index.html; \
    server_name _; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        include snippets/fastcgi-php.conf; \
        fastcgi_pass unix:/run/php/php8.3-fpm.sock; \
    } \
    location ~ /\.ht { \
        deny all; \
    } \
}' > /etc/nginx/sites-available/default \
    && rm -f /etc/nginx/sites-enabled/default \
    && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

# 6. Cấu hình Supervisor để chạy song song Nginx và PHP-FPM ở chế độ foreground
RUN echo '[supervisord]\n\
nodaemon=true\n\n\
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

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]