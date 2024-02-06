# nginx用のアプリサーバーDockerファイル

# マルチステージビルド
FROM composer:2.6.4 as composer
FROM node:20.10-bullseye-slim as node

# php
FROM php:8.2.13-fpm-alpine3.18

RUN mkdir /app

# timezone
ENV TZ=Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# マルチステージビルドしたcomposerコンテナからcomposerをコピー
COPY --from=composer /usr/bin/composer /usr/bin/composer

# マルチステージビルドしたnode.jsコンテナからnodeとnpmをコピー
COPY --from=node /usr/local/bin/node /usr/local/bin/
COPY --from=node /usr/local/lib/node_modules/ /usr/local/lib/node_modules/
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN apk --update --no-cache add \
            curl \
            bash \
            git \
            nodejs \
            npm \
            libzip-dev \
            libpng-dev \
            autoconf \
            linux-headers \
            freetype-dev \
            libjpeg-turbo-dev \
            libpng-dev \
        && git clone https://github.com/phpredis/phpredis.git /usr/src/php/ext/redis \
        && docker-php-ext-install \
            zip \
            pdo_mysql \
            sockets \
            redis \
            bcmath \
            gd \
        && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-enable opcache \
        && rm -rf /var/cache/apk/*

WORKDIR /app

COPY ./ /app

# php.iniの設定
COPY ./.docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

RUN ln -sf /proc/1/fd/1 /app/storage/logs/schedule.log

#yarnをグローバルでinstall
RUN npm install -g yarn

