FROM php:8.3-apache

# pdo_mysql を有効化（必須）
RUN docker-php-ext-install pdo_mysql \
 && a2enmod rewrite

ENV TZ=Asia/Tokyo
WORKDIR /var/www/html