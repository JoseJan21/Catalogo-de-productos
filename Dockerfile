# Usa la imagen oficial de PHP 7.4 con Apache
FROM php:7.4-apache

# Instala las extensiones necesarias para tu aplicación (ajusta según tus necesidades)
RUN apt-get update && apt-get install -y libpng-dev libjpeg62-turbo-dev libfreetype6-dev

# Configura y habilita las extensiones de PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql

# Copia los archivos de tu proyecto al contenedor
COPY . /var/www/html/

# Exponer el puerto 80 para el tráfico web
EXPOSE 80

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Inicia Apache
CMD ["apache2-foreground"]

