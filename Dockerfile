FROM php:8.2-apache

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitar módulos de Apache
RUN a2enmod rewrite

# Copiar archivos del proyecto al servidor
COPY . /var/www/html/

# Dar permisos
RUN chown -R www-data:www-data /var/www/html/

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "/var/www/html"]