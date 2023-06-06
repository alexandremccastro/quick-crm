FROM php:fpm-alpine
RUN docker-php-ext-install opcache pdo pdo_mysql
COPY docker-compose/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/html/
COPY composer.json composer.lock ./
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# copy entrypoint.sh
COPY ./entrypoint.sh .
RUN sed -i 's/\r$//g' /var/www/html/entrypoint.sh
RUN chmod +x /var/www/html/entrypoint.sh

# copy all files
COPY . .

RUN composer dump-autoload --optimize

# run entrypoint.sh
ENTRYPOINT ["/var/www/html/entrypoint.sh"]

CMD [ "php-fpm" ]
