# apache用のアプリサーバーDockerファイル

# マルチステージビルド
FROM composer:2.6.4 as composer
FROM node:20.10-bullseye-slim as node

FROM php:8.1-apache-bullseye

ENV TZ=Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# マルチステージビルドしたcomposerコンテナからcomposerをコピー
COPY --from=composer /usr/bin/composer /usr/bin/composer

# マルチステージビルドしたnode.jsコンテナからnodeとnpmをコピー
COPY --from=node /usr/local/bin/node /usr/local/bin/
COPY --from=node /usr/local/lib/node_modules/ /usr/local/lib/node_modules/
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm

RUN npm install -g yarn

RUN apt-get update && \
    apt-get install -y gnupg gosu curl ca-certificates zip unzip git supervisor sqlite3 libcap2-bin libpng-dev dnsutils vim && \
		# ルート以外へのアクセス許可
		a2enmod rewrite && \
		rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 不足しているPHP拡張をインストール
RUN docker-php-ext-install bcmath pdo_mysql

#PHPが1024未満のポート（例：ポート80や443）にバインドする権限を付与
RUN setcap "cap_net_bind_service=+ep" /usr/local/bin/php

# php.iniの設定
COPY ./.docker/app/php.ini /usr/local/etc/php/php.ini
COPY ./.docker/app/apache/000-default.conf /etc/apache2/sites-available/

WORKDIR /var/www/app