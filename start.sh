#!/bin/bash

# Secret Files にある .env を Laravel のルートにコピー（Render上でのみ存在する）
[ -f /etc/secrets/.env ] && cp /etc/secrets/.env /var/www/html/.env

# Laravel キャッシュクリア・再構築
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Apache 起動
apache2-foreground
