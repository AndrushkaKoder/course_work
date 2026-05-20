FROM php:8.5-fpm-alpine

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN apk add --no-cache \
    bash \
    curl \
    git \
    unzip \
    zip \
    libxml2-dev \
    oniguruma-dev \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libzip-dev \
    shadow \
    supervisor

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
    pdo_pgsql \
    pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

RUN usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./

RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader --no-scripts

COPY . .

RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

RUN mkdir -p /etc/supervisor/conf.d /var/www/storage/logs

COPY ./_docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

COPY ./_docker/supervisor/supervisord.conf /etc/supervisor/supervisord.conf
COPY ./_docker/supervisor/queue.conf /etc/supervisor/conf.d/queue.conf

RUN chown -R www-data:www-data /var/www \
    && chown -R www-data:www-data /var/www/storage/logs

EXPOSE 9000

CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
