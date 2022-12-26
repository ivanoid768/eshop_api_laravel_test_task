FROM harshalone/laravel-9-prod:v2

# RUN set -ex \
#   && apk --no-cache add \
#     postgresql-dev
RUN apt-get update && \
    apt-get install --yes --force-yes \
    cron g++ gettext libicu-dev openssl \
    libc-client-dev libkrb5-dev  \
    libxml2-dev libfreetype6-dev \
    libgd-dev libmcrypt-dev bzip2 \
    libbz2-dev libtidy-dev libcurl4-openssl-dev \
    libz-dev libmemcached-dev libxslt-dev git-core libpq-dev \
    libzip4 libzip-dev libwebp-dev

RUN docker-php-ext-install pgsql pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN composer install

WORKDIR /var/www/html

RUN php artisan migrate --force -n
RUN php artisan db:seed --class="CategorySeeder"
RUN php artisan db:seed --class="ProductSeeder"
# RUN php artisan db:seed --class="DatabaseSeeder"
# Ensure all of our files are owned by the same user and group.
RUN chown -R application:application .
ENTRYPOINT ["php artisan serve"]