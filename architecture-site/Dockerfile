FROM ubuntu:22.04

ARG PHP_VERSION=8.3
ARG NODE_VERSION=20

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1

# =========================================================
# 1. SYSTEM + PHP
# =========================================================

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


# =========================================================
# 2. PHP UPLOAD CONFIG
# =========================================================

RUN printf '%s\n' \
    'upload_max_filesize=20M' \
    'post_max_size=25M' \
    'max_file_uploads=20' \
    'memory_limit=256M' \
    > /etc/php/${PHP_VERSION}/fpm/conf.d/99-upload.ini


# =========================================================
# 3. NODE.JS / NPM
# =========================================================

RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && node --version \
    && npm --version \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


# =========================================================
# 4. COMPOSER
# =========================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


# =========================================================
# 5. APPLICATION
# =========================================================

WORKDIR /var/www/html

COPY . .


# =========================================================
# 6. FRONTEND BUILD
# =========================================================

RUN if [ -f package-lock.json ]; then \
        npm ci; \
    else \
        npm install; \
    fi \
    && npm run build \
    && test -f public/build/manifest.json \
    && echo "==========================================" \
    && echo "VITE BUILD OK" \
    && echo "public/build/manifest.json exists" \
    && echo "=========================================="


# =========================================================
# 7. PHP DEPENDENCIES
# =========================================================

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# =========================================================
# 8. LARAVEL DIRECTORIES
# =========================================================

RUN mkdir -p \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
        /run/php


# =========================================================
# 9. PERMISSIONS
# =========================================================

RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /run/php \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache


# =========================================================
# 10. STORAGE LINK
# =========================================================

RUN rm -rf public/storage \
    && php artisan storage:link \
    && echo "==========================================" \
    && echo "STORAGE LINK CREATED" \
    && ls -la public/storage \
    && echo "=========================================="


# =========================================================
# 11. CLEAR LARAVEL CACHE
# =========================================================

RUN php artisan optimize:clear


# =========================================================
# 12. LIVEWIRE ROUTE CHECK
# =========================================================

RUN php artisan route:list \
    | grep -i livewire \
    || true


# =========================================================
# 13. PHP-FPM CONFIG
# =========================================================

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


RUN echo "==========================================" \
    && echo "PHP-FPM CONFIG" \
    && grep -E '^(listen|user|group|clear_env)' \
        /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf \
    && echo "=========================================="


# =========================================================
# 14. NGINX
# =========================================================

RUN rm -f /etc/nginx/sites-enabled/default \
    && cat > /etc/nginx/sites-available/default <<'NGINX'

server {
    listen 0.0.0.0:10000 default_server;
    listen [::]:10000 default_server;

    server_name _;

    root /var/www/html/public;

    index index.php index.html;

    client_max_body_size 50M;


    # =====================================================
    # LIVEWIRE
    # =====================================================

    location ~ ^/livewire-[^/]+/ {
        try_files $uri $uri/ /index.php?$query_string;
    }


    # =====================================================
    # STORAGE
    # =====================================================

    location ^~ /storage/ {
        try_files $uri $uri/ /index.php?$query_string;
    }


    # =====================================================
    # MEDIA
    # =====================================================

    location ^~ /media/ {
        try_files $uri $uri/ /index.php?$query_string;
    }


    # =====================================================
    # LARAVEL
    # =====================================================

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }


    # =====================================================
    # FRONT CONTROLLER
    # =====================================================

    location ~ ^/index\.php(/|$) {

        include fastcgi_params;

        fastcgi_pass 127.0.0.1:9000;

        fastcgi_index index.php;

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_param PATH_INFO $fastcgi_path_info;
    }


    # =====================================================
    # BLOCK OTHER PHP FILES
    # =====================================================

    location ~ \.php$ {
        return 404;
    }


    # =====================================================
    # BLOCK HIDDEN FILES
    # =====================================================

    location ~ /\.ht {
        deny all;
    }


    # =====================================================
    # STATIC FILES
    # =====================================================

    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|webp|woff|woff2|ttf)$ {

        expires 7d;

        add_header Cache-Control "public, max-age=604800";

        try_files $uri =404;
    }
}

NGINX


RUN ln -s /etc/nginx/sites-available/default \
    /etc/nginx/sites-enabled/default


RUN nginx -t


# =========================================================
# 15. SUPERVISOR
# =========================================================

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


# =========================================================
# 16. FINAL PERMISSIONS
# =========================================================

RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
    && chmod -R 775 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache


# =========================================================
# 17. PORT
# =========================================================

EXPOSE 10000


# =========================================================
# 18. START
# =========================================================

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]