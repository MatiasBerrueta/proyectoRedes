FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar el codigo en src al directorio que va usar el contenedor 
COPY src/ /var/www/html/

# Dar permisos a Apache para manipular el directorio
RUN chown -R www-data:www-data /var/www/html
