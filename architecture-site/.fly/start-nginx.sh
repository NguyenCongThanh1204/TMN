#!/usr/bin/env bash

# Xóa cấu hình mặc định của Nginx nếu có
rm -f /etc/nginx/sites-enabled/default

# Copy hoặc liên kết file cấu hình chứa cổng 10000 của bạn vào thư mục chạy của Nginx
if [ -f /var/www/html/nginx/sites-available/default ]; then
    ln -sf /var/www/html/nginx/sites-available/default /etc/nginx/sites-enabled/default
fi

# Đợi một chút rồi chạy Nginx
sleep 0.25 && exec nginx -g "daemon off;"