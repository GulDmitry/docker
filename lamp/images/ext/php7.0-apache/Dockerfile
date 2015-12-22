FROM php:7.0-apache

RUN a2enmod rewrite expires

# Install modules
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        php5-xdebug \
        php5-cli \
        php5-mysql \
        php5-curl \
    && docker-php-ext-install iconv mcrypt mysqli pdo pdo_mysql

RUN echo " \
      post_max_size = 80M\n\
      upload_max_filesize = 80M\n\
      memory_limit = 800M\n\
      error_reporting = E_ALL & ~E_STRICT & ~E_DEPRECATED\n\
      html_errors = On\n\
      display_errors = On\n\
      date.timezone = Europe/Minsk\n\
" > /usr/local/etc/php/conf.d/docker-local.ini

CMD ["apache2-foreground"]
