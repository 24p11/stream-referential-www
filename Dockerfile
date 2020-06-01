FROM php:7.3
RUN apt-get update && apt-get install -y openssl zip unzip zlib1g-dev git libicu-dev g++ zip unzip npm
RUN docker-php-ext-configure intl
RUN docker-php-ext-install pdo mbstring intl pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install
RUN npm install
RUN npm run production
RUN mv /app/.env.example /app/.env
RUN php artisan key:generate
ADD https://github.com/ufoscout/docker-compose-wait/releases/download/2.2.1/wait /wait
RUN chmod +x /wait

