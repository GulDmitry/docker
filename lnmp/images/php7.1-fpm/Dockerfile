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

RUN echo " \
    ; For debug in CLI run before script `export XDEBUG_CONFIG='idekey=PHPSTORM'`.\n\
    ; PHP Storm IDE key is PHPSTORM\n\
    ; To run CLI debug via PHPStorm IDE setup a server (where host is private IP), match routes\n\
    ; and run {export PHP_IDE_CONFIG='serverName=vagrant'}\n\
    ; For debug service (SOAP, REST) set cookie on client setCookie('XDEBUG_SESSION', 'netbeans-xdebug')\n\
    ; then debug progect. Some times need restart apache and Netbeans.\n\
    ; Remote settings\n\
    ; xdebug.remote_host=172.17.0.1\n\
    ; xdebug.remote_host=172.16.238.11\n\
    \n\
    xdebug.remote_autostart=on\n\
    xdebug.remote_enable=on\n\
    xdebug.remote_handler=dbgp\n\
    xdebug.remote_mode=req\n\
    xdebug.remote_port=9000\n\
    ; if set the remote_host is ignored\n\
    xdebug.remote_connect_back=on\n\
    xdebug.idekey=PHPSTORM\n\
    \n\
    ; General\n\
    xdebug.show_local_vars=On\n\
    xdebug.dump.SERVER=HTTP_HOST, SERVER_NAME\n\
    xdebug.dump_globals=On\n\
    xdebug.collect_params=4\n\
    xdebug.auto_trace=off\n\
    xdebug.collect_includes=on\n\
    xdebug.collect_return=off\n\
    xdebug.default_enable=on\n\
    xdebug.extended_info=1\n\
    xdebug.manual_url=http://www.php.net\n\
    xdebug.show_mem_delta=1\n\
    xdebug.max_nesting_level=250\n\
    \n\
    ;var_dump\n\
    ;Default value: 128\n\
    xdebug.var_display_max_children=164\n\
    ;Default value: 512\n\
    xdebug.var_display_max_data=640\n\
    ;Default value: 3\n\
    xdebug.var_display_max_depth=6\n\
    \n\
    ; Trace options\n\
    ;xdebug.trace_format=0\n\
    ;xdebug.trace_output_dir=/var/www/debug\n\
    ;xdebug.trace_options=0\n\
    ;xdebug.trace_output_name=tracelog\n\
    \n\
    ; Profiling\n\
    ;xdebug.profiler_append=0\n\
    ;xdebug.profiler_enable=0\n\
    ;xdebug.profiler_enable_trigger=0\n\
    ;xdebug.profiler_output_dir=/var/www/debug\n\
    ;xdebug.profiler_output_name=scriptprofile.out\n\
          " > /usr/local/etc/php/conf.d/docker-xdebug.ini

RUN echo " \
      short_open_tag = Off\n\
      post_max_size = 100M\n\
      upload_max_filesize = 100M\n\
      memory_limit = 512M\n\
      error_reporting = E_ALL & ~E_STRICT & ~E_DEPRECATED\n\
      html_errors = On\n\
      display_errors = On\n\
      date.timezone = Europe/Minsk\n\
" > /usr/local/etc/php/conf.d/docker-local.ini

CMD ["php-fpm"]
