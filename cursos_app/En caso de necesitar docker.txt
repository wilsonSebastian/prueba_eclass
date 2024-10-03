# Usar una imagen oficial de PHP con Apache
FROM php:7.4-apache

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Instalar dependencias y extensiones necesarias para CakePHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar todos los archivos del proyecto al contenedor
COPY . .

# Instalar las dependencias del proyecto utilizando Composer
RUN composer install --no-dev --optimize-autoloader

# Habilitar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Copiar el archivo de configuración de Apache
COPY ./docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Configurar permisos para las carpetas que CakePHP necesita escribir
RUN chown -R www-data:www-data /var/www/html/tmp \
    && chown -R www-data:www-data /var/www/html/logs

# Exponer el puerto 80 para acceder al servidor web
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
