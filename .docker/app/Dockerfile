FROM php:7.4-fpm-alpine
#ARG uid=999
#ARG user=999
MAINTAINER Farjana Begum <mahjabin4bd@gmail.com>

ENV PECL_EXTENSIONS="pcov psr redis xdebug"
ENV PHP_EXTENSIONS="bz2 exif gd gettext intl pcntl pdo_mysql zip"

# Install system dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS libtool \
    && apk add --no-cache bzip2-dev gettext-dev git icu icu-dev libintl libpng-dev libzip-dev mysql-client \
    # Install and enable PECL extensions
    && docker-php-source extract \
    && pecl channel-update pecl.php.net \
    && pecl install $PECL_EXTENSIONS \
    && cd /usr/src/php/ext/ \
    && docker-php-ext-enable $PECL_EXTENSIONS \
    && docker-php-ext-configure opcache --enable-opcache \
    # Install and enable PHP extensions
    && docker-php-ext-install -j "$(nproc)" $PHP_EXTENSIONS \
    # Clean up
    && apk del -f .build-deps \
    && cd /usr/local/etc/php/conf.d/ \
    && pecl clear-cache \
    && docker-php-source delete \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* /usr/share/doc/* /usr/share/man/*

#Myself create system user to run composer and artisan comands
#Run useradd -G www-data,root -u $uid -d /home/$user $user
#Run mkdir -p /home/$user/.composer && \
#chown -R $user:$user /home/$user

# Install latest composer with prestissimo
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# run composer, chmod files, setup laravel key
#RUN chmod -R a+w storage/
#RUN chmod -R a+w bootstrap/cache/
#RUN php artisan key:generate
#RUN php artisan migrate

# Set working directory and non-root user
#WORKDIR /var/www/html
#USER farjana
USER www-data
#Myself add user
#USER $user
#ADD . /var/www/html
#RUN chown -R www-data:www-data /var/www/html
#RUN chmod -R 777 www-data:www-data /var/www/html

#RUN addgroup -S root \
#    && adduser -S -G root -h /var/www/html -D root

#USER root
#RUN mkdir /var/www/html/mount-data
#VOLUME ["/var/www/html/mount-data"]
WORKDIR /var/www/html

