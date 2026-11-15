FROM php:8.2-apache

# Install mysqli extension for MySQL connections
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy your project files into the Apache web root
COPY . /var/www/html/

# Enable Apache mod_rewrite
RUN a2enmod rewrite

EXPOSE 80

