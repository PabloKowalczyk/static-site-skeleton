FROM php:7.4.9-cli-alpine AS php_builder

RUN apk add su-exec
RUN mkdir -p  /var/www/.composer \
    && chown www-data:www-data /var/www/.composer

COPY --from=composer:2.0.0-alpha2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_HOME /var/www/.composer

WORKDIR /app

COPY ./composer.json ./composer.lock ./

RUN composer install --no-scripts --no-dev

COPY ./src ./src
COPY ./config ./config
COPY ./bin ./bin
COPY ./src ./src
COPY ./translations ./translations
COPY ./templates ./templates
COPY ./public ./public
COPY ./.env ./docker/deploy/.env.local ./

RUN composer symfony:dump-env prod && \
    composer install -a --no-dev && \
    bin/console cache:warmup -e prod

FROM node:10.22-alpine AS assets_builder

WORKDIR /app

COPY ./package.json ./yarn.lock ./

RUN yarn install

COPY ./webpack.config.js ./webpack.config.js
COPY ./assets ./assets

RUN yarn build

FROM alpine:3.12.0 AS archive_builder

WORKDIR /app

COPY --from=php_builder /app /artifact
COPY --from=assets_builder /app/public/build /artifact/public/build

RUN tar -jcvf artifact.tar.bz2 -C /artifact/ . && du -h artifact.tar.bz2

FROM scratch AS artifact

COPY --from=archive_builder ./app/artifact.tar.bz2 /haccp-deploy.tar.bz2
