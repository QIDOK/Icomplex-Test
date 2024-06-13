FROM php:8.2-apache

RUN apt-get update && \
    apt-get install -y libzip-dev zip libpng-dev git npm

RUN docker-php-ext-install pdo_mysql zip gd

RUN a2enmod rewrite

COPY docker/web.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html
COPY . /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
RUN composer update
RUN npm install
RUN npm run build
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2ctl", "-D", "FOREGROUND"]
