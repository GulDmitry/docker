FROM php:7.1-fpm

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        git \
        zlib1g-dev \
        g++ \
        libicu-dev

# Install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

# Install mysql
RUN docker-php-ext-install iconv mysqli pdo pdo_mysql

# Install bcmath
RUN docker-php-ext-install bcmath

# Install bz2
RUN apt-get install -y libbz2-dev
RUN docker-php-ext-install zip

# Install GD
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

# Install mbstring
RUN docker-php-ext-install mbstring

# Install mcrypt
RUN docker-php-ext-install -j$(nproc) iconv mcrypt

# Install imap
RUN apt-get install -y openssl
RUN apt-get install -y libc-client-dev
RUN apt-get install -y libkrb5-dev
RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN docker-php-ext-install imap

# Install xhprof, xdebug
RUN pecl install -o -f xdebug \
    && rm -rf /tmp/pear

#RUN docker-php-ext-enable xhprof
RUN docker-php-ext-enable xdebug

COPY docker-xdebug.ini /usr/local/etc/php/conf.d/
COPY docker-local.ini /usr/local/etc/php/conf.d/

CMD ["php-fpm"]
