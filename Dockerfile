# ETAPA 1: builder
FROM php:8.2-cli-alpine AS builder

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

WORKDIR /app

COPY src/composer.json src/composer.lock ./

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY src/ ./

RUN composer dump-autoload --optimize

# ETAPA 2: runner
FROM php:8.2-apache-bullseye AS runner 

RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

COPY --from=builder --chown=www-data:www-data /app /var/www/html

WORKDIR /var/www/html

EXPOSE 80