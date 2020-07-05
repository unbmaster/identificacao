FROM debian:stable-slim

RUN apt-get update -y; \
    apt-get install --no-install-recommends -y \
    nginx=1.18.0 php-fpm=7.3 sqlite3=3.32.3 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY ./docker/nginx/custom-default     /etc/nginx/sites-available/default
COPY ./docker/nginx/certificate.crt    /etc/ssl/certificate.crt
COPY ./docker/nginx/private.key        /etc/ssl/private.key
COPY ./docker/php/custom-www.conf      /etc/php/7.3/fpm/pool.d/www.conf
COPY ./docker/php/custom-php.ini       /etc/php/7.3/cli/php.ini
COPY ./                                /var/www

#CMD /etc/init.d/php7.3-fpm start && nginx -g "daemon off;"
#CMD /etc/init.d/php7.3-fpm start && nginx -g "daemon off;"

CMD ["nginx", "-g", "daemon off;"]