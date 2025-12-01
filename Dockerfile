#########################################
# 1. FRONTEND BUILD (Vue + Inertia + Vite)
#########################################
FROM node:20-alpine AS frontend
WORKDIR /app

COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.* ./
RUN npm run build


#########################################
# 2. BACKEND dependencies
#########################################
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-plugins --no-scripts


#########################################
# 3. BASE PHP IMAGE (будет общая для App и Worker)
#########################################
FROM php:8.3-fpm-alpine AS base
WORKDIR /var/www

RUN apk add --no-cache \
        git zip unzip icu-dev oniguruma-dev libpq-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-install pdo_pgsql intl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del $PHPIZE_DEPS


#########################################
# 4. APP IMAGE (php-fpm)
#########################################
FROM base AS app
WORKDIR /var/www

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache

CMD ["php-fpm"]


#########################################
# 5. WORKER IMAGE (php-cli)
#########################################
FROM base AS worker
WORKDIR /var/www

COPY . .
COPY --from=vendor /app/vendor ./vendor

CMD ["php", "artisan", "queue:work", "--sleep=1", "--tries=3"]
