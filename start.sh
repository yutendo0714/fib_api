#!/bin/bash

# Laravel準備
php artisan config:cache
php artisan route:cache
php artisan view:cache

# PHP-FPM起動
service php8.2-fpm start

# Nginx起動（フォアグラウンド）
nginx -g "daemon off;"
