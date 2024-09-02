FROM php:8.2-fpm

# Install zip extension
RUN docker-php-ext-install zip
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /app
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0
