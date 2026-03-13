FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && apt-get install -y curl gnupg lsb-release ca-certificates zip \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install nodejs -y \
    && npx playwright install --with-deps \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN composer global require phpunit/phpunit \
    && ln -s /root/.composer/vendor/bin/phpunit /usr/local/bin/phpunit

COPY src/composer.json src/composer.lock /var/www/html/

RUN composer install

COPY src/ /var/www/html/

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite