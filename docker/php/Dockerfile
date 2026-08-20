FROM php:8.5-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git curl unzip zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini

# Copy only composer files first so the dependency layer is cached
# and doesn't rebuild every time your source code changes.
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-interaction --no-scripts

# Copy the rest of the app (this layer gets overridden at runtime by the
# bind mount in docker-compose.yaml — it just makes the image usable
# on its own too, e.g. for `docker run`).
COPY . .

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]

EXPOSE 9000
CMD ["php-fpm"]
