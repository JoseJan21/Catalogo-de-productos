# Usa una imagen base de PHP con Apache
FROM php:8.1-apache

# Instala las dependencias necesarias (si usas una base de datos como MySQL)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto en el contenedor
COPY . /var/www/html/

# Expone el puerto 80 (puerto por defecto de Apache)
EXPOSE 80
