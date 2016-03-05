FROM php:5.6-fpm

RUN docker-php-ext-configure mbstring 
RUN docker-php-ext-install mbstring 
RUN docker-php-ext-enable mbstring 

RUN apt-get update && apt-get install zip unzip 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer