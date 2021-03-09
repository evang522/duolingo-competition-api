FROM php:7.4-fpm

#RUN docker-php-ext-install pdo_mysql

RUN pecl install apcu

RUN apt-get update && \
apt-get install -y \
zlib1g-dev && \
apt-get install -y libzip-dev

# core extensions
RUN docker-php-ext-enable opcache
RUN docker-php-ext-install bcmath \
    && docker-php-ext-install zip


RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN docker-php-ext-enable apcu


# composer
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_HOME /var/www/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#RUN composer global require hirak/prestissimo
RUN composer global require maglnet/composer-require-checker
RUN chown -R www-data:www-data $COMPOSER_HOME
ENV PATH "${PATH}:/var/www/composer/vendor/bin"

WORKDIR /usr/src/app


RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin
