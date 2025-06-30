FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=node:20.16 /usr/local/bin /usr/local/bin
COPY --from=node:20.16 /usr/local/lib /usr/local/lib

RUN apt-get update \
    && apt-get -y install git zip unzip vim \
    && docker-php-ext-install pdo_mysql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html
COPY ./src /var/www/html

# Secrets を Laravel に配置
RUN cp /etc/secrets/.env /var/www/html/.env

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache
