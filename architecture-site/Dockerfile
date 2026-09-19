FROM ubuntu:22.04

ARG PHP_VERSION=8.3
ARG NODE_VERSION=20

ENV DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1 \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/html/database/database.sqlite

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

RUN curl -fsSL https://deb.nodesource.com/setup_${NODE_VERSION}.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && node --version \
    && npm --version \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer


WORKDIR /var/www/html

COPY . .


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


RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist



RUN mkdir -p \
        database \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
        /run/php

RUN touch /var/www/html/database/database.sqlite


RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        /var/www/html/database \
    && chown -R www-data:www-data /run/php \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/database \
    && chmod 664 /var/www/html/database/database.sqlite

USER www-data

RUN php artisan migrate:fresh --seed --force

USER root


RUN rm -rf public/storage \
    && php artisan storage:link \
    && echo "==========================================" \
    && echo "STORAGE LINK CREATED" \
    && ls -la public/storage \
    && echo "=========================================="

RUN php artisan optimize:clear


RUN php artisan route:list \
    | grep -i livewire \
    || true

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



RUN rm -f /etc/nginx/sites-enabled/default \
    && cat > /etc/nginx/sites-available/default <<'NGINX'

server {
    listen 0.0.0.0:10000 default_server;
    listen [::]:10000 default_server;

    server_name _;

    root /var/www/html/public;

    index index.php index.html;

    client_max_body_size 50M;

    location ~ ^/livewire-[^/]+/ {
        try_files $uri $uri/ /index.php?$query_string;
    }


    location ^~ /storage/ {
        try_files $uri $uri/ /index.php?$query_string;
    }


    location ^~ /media/ {
        try_files $uri $uri/ /index.php?$query_string;
    }


    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }


    location ~ ^/index\.php(/|$) {

        include fastcgi_params;

        fastcgi_pass 127.0.0.1:9000;

        fastcgi_index index.php;

        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

        fastcgi_param PATH_INFO $fastcgi_path_info;
    }


    location ~ \.php$ {
        return 404;
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

RUN nginx -t

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


RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        /var/www/html/database \
    && chmod -R 775 \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        /var/www/html/database


EXPOSE 10000


CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/conf.d/supervisord.conf"]