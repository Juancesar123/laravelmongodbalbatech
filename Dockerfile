FROM php:7.3-fpm
        
RUN apt-get update && apt-get install -y autoconf pkg-config apt-utils mariadb-client git vim openssl zip libssl-dev unzip\
    && docker-php-ext-install pdo_mysql mbstring pdo

RUN pecl install mongodb sqlsrv pdo_sqlsrv xdebug \
    && docker-php-ext-enable mongodb sqlsrv pdo_sqlsrv xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer