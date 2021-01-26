FROM php:8.0-fpm-alpine

RUN apk add --no-cache bash

RUN set -ex \
  && apk --no-cache add \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY composer.json composer.lock ./
RUN composer update

COPY docker/wait.sh /usr/local/bin/wait.sh

CMD bash -c "wait.sh postgres:5432 -- symfony console doctrine:database:create --if-not-exists && wait.sh postgres:5432 -- symfony console doctrine:migrations:migrate --no-interaction --allow-no-migration" \
    && php-fpm
