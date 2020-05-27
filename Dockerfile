FROM php:7.3
RUN apt-get update && apt-get install -y openssl zip unzip zlib1g-dev libicu-dev g++ zip unzip npm
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo mbstring intl
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install
RUN npm install
RUN npm run production
RUN php artisan migrate

EXPOSE 8181
CMD php artisan serve --host=0.0.0.0 --port=8181

