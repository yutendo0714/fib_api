# =========================
# PHP-FPM + Nginx + Node + Composerを含むDockerfile
# =========================
FROM php:8.2-fpm

# タイムゾーン・環境変数設定
ENV TZ=Asia/Tokyo

# php.ini
COPY ./docker/php/php.ini /usr/local/etc/php/php.ini

# Composer（最新を使用）
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Node.js LTS
COPY --from=node:20.16 /usr/local/bin /usr/local/bin
COPY --from=node:20.16 /usr/local/lib /usr/local/lib

# 必要パッケージとPHP拡張
RUN apt-get update \
 && apt-get install -y nginx git zip unzip vim curl \
 && docker-php-ext-install pdo_mysql bcmath \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Laravel作業ディレクトリ
WORKDIR /var/www/html

# Laravelプロジェクトをコンテナにコピー（Renderではvolume不可）
COPY ./src /var/www/html

# Nginx config
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# 実行時スクリプト（nginx + php-fpm）
COPY ./start.sh /start.sh
RUN chmod +x /start.sh

# ポート指定（Render側に合わせて80番）
EXPOSE 80

# コンテナ起動時コマンド
CMD ["/start.sh"]
