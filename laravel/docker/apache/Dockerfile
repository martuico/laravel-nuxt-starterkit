FROM php:7.2.27-apache-buster

ARG XDEBUG=false
ENV XDEBUG ${XDEBUG}
ARG COMPOSER=false
ENV COMPOSER ${COMPOSER}}

## in case user has different UID
ARG PUID=1000
ARG PGID=1000
ENV PUID ${PUID}
ENV PGID ${PGID}


RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libzip-dev \
        libmagickwand-dev \
        imagemagick \
        libcurl4-openssl-dev \
    && docker-php-ext-configure gd  --with-freetype-dir=/usr --with-jpeg-dir=/usr --with-png-dir=/usr \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install zip xml intl curl\
    && docker-php-ext-install pdo pdo_mysql

# install composer
RUN if [ ${COMPOSER} = true ]; then \
        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && php composer-setup.php && php -r "unlink('composer-setup.php');" && cp composer.phar bin/composer \
    ;fi

COPY . /var/www/html

WORKDIR /var/www/html

RUN usermod -u ${PUID} www-data && groupmod -g ${PGID} www-data
RUN chown -R www-data:www-data /var/www && chmod -Rv ug+rwx storage bootstrap/cache

# replace default apache configuration
RUN cat docker/apache/site.conf > /etc/apache2/sites-enabled/000-default.conf

RUN a2enmod rewrite headers
CMD /usr/sbin/apache2ctl -D FOREGROUND

