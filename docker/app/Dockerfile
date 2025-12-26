FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git curl zip unzip icu-dev oniguruma-dev libzip-dev \
    freetype-dev libjpeg-turbo-dev libpng-dev libwebp-dev \
    $PHPIZE_DEPS \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install pdo pdo_mysql mbstring zip intl gd \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && rm -rf /var/cache/apk/* /tmp/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html