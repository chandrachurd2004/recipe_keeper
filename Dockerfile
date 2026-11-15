FROM php:8.2-apache

# Copy your project files into the Apache web root
COPY . /var/www/html/

# Enable Apache mod_rewrite (useful for routing and frameworks)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

