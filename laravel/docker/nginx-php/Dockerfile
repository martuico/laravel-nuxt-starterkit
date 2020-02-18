FROM alpine:3.9

ARG PHP_VERSION
ENV IMAGE_PHP_VERSION=7

# Create user
RUN adduser -D -u 1000 -g 1000 -s /bin/sh www-data && \
    mkdir -p /www && \
    chown -R www-data:www-data /www

# Install tini - 'cause zombies - see: https://github.com/ochinchina/supervisord/issues/60
# (also pkill hack)
RUN apk add --no-cache --update tini

# Install a golang port of supervisord
COPY --from=ochinchina/supervisord:latest /usr/local/bin/supervisord /usr/bin/supervisord

# Install nginx & gettext (envsubst)
# Create cachedir and fix permissions
RUN apk add --no-cache --update \
    gettext \
    nginx && \
    mkdir -p /var/cache/nginx && \
    chown -R www-data:www-data /var/cache/nginx && \
    chown -R www-data:www-data /var/lib/nginx && \
    chown -R www-data:www-data /var/tmp/nginx

# Install PHP/FPM + Modules
RUN apk add --no-cache --update \
    php${IMAGE_PHP_VERSION} \
    php${IMAGE_PHP_VERSION}-apcu \
    php${IMAGE_PHP_VERSION}-bcmath \
    php${IMAGE_PHP_VERSION}-bz2 \
    php${IMAGE_PHP_VERSION}-cgi \
    php${IMAGE_PHP_VERSION}-ctype \
    php${IMAGE_PHP_VERSION}-curl \
    php${IMAGE_PHP_VERSION}-dom \
    php${IMAGE_PHP_VERSION}-fpm \
    php${IMAGE_PHP_VERSION}-ftp \
    php${IMAGE_PHP_VERSION}-gd \
    php${IMAGE_PHP_VERSION}-iconv \
    php${IMAGE_PHP_VERSION}-json \
    php${IMAGE_PHP_VERSION}-mbstring \
    php${IMAGE_PHP_VERSION}-oauth \
    php${IMAGE_PHP_VERSION}-opcache \
    php${IMAGE_PHP_VERSION}-openssl \
    php${IMAGE_PHP_VERSION}-pcntl \
    php${IMAGE_PHP_VERSION}-pdo \
    php${IMAGE_PHP_VERSION}-pdo_mysql \
    php${IMAGE_PHP_VERSION}-phar \
    php${IMAGE_PHP_VERSION}-redis \
    php${IMAGE_PHP_VERSION}-session \
    php${IMAGE_PHP_VERSION}-simplexml \
    php${IMAGE_PHP_VERSION}-soap \
    php${IMAGE_PHP_VERSION}-tokenizer \
    php${IMAGE_PHP_VERSION}-xdebug \
    php${IMAGE_PHP_VERSION}-xml \
    php${IMAGE_PHP_VERSION}-xmlreader \
    php${IMAGE_PHP_VERSION}-xmlwriter \
    php${IMAGE_PHP_VERSION}-zip \
    php${IMAGE_PHP_VERSION}-zlib \
    php${IMAGE_PHP_VERSION}-mcrypt \
    php${IMAGE_PHP_VERSION}-fileinfo \
    php${IMAGE_PHP_VERSION}-zmq \
    git

RUN apk add --no-cache  \
    php${IMAGE_PHP_VERSION}-mysqli \
    mysql

# Install COMPOSER
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --install-dir=bin --filename=composer



# Runtime env vars are envstub'd into config during entrypoint
ENV SERVER_NAME="localhost"
ENV SERVER_ALIAS=""
ENV SERVER_ROOT=/var/www/html/public

# Alias defaults to empty, example usage:
ENV SERVER_ALIAS='myc.localhost'

COPY ./conf/supervisord/supervisord.conf /supervisord.conf
COPY ./conf/php/php-fpm-www.conf /etc/php7/php-fpm.d/www.conf
COPY ./conf/nginx/nginx.conf.template /nginx.conf.template
# COPY ./conf/nginx/conf.d/myc.conf /etc/nginx/conf.d/default.conf
COPY ./conf/nginx/conf.d /etc/nginx/conf.d
COPY ./conf/php/php.ini /etc/php7/php.ini
COPY docker-entrypoint.sh /docker-entrypoint.sh

# Nginx on :80
EXPOSE 80
WORKDIR /var/www/html

# ENTRYPOINT [ "tini", "--", "/docker-entrypoint.sh"]
ENTRYPOINT ["sh" "/docker-entrypoint.sh"]
RUN ["chmod", "+x", "/docker-entrypoint.sh"]

