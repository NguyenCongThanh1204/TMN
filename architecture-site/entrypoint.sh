#!/bin/sh
# Tự động chạy migrate và dọn dẹp cache khi container khởi động
php artisan migrate --force
php artisan config:clear
php artisan cache:clear

# Khởi động dịch vụ chính (Supervisord chứa Nginx và PHP-FPM)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf