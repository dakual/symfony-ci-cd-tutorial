FROM php:8.1-fpm

WORKDIR /app

## Copy project files to workdir
COPY app .

## Change files owner to php-fpm default user
RUN chown -R www-data:www-data .