FROM php:8.0-fpm-alpine

RUN apk add --no-cache bash

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev \
    rabbitmq-c-dev

RUN apk add --no-cache $PHPIZE_DEPS \
    && docker-php-ext-install sockets \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install redis \
    && docker-php-ext-enable redis

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/install-php-extensions
RUN install-php-extensions amqp

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY composer.json composer.lock ./
RUN composer install

COPY docker/wait.sh /usr/local/bin/wait.sh


CMD bash -c "./docker/init.sh" \
    && php-fpm
