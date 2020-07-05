FROM debian:stable-slim

RUN apt-get update -y \
    && apt-get install --no-install-recommends -y \
    nginx=1.14.2-2+deb10u1 php-fpm=2:7.3+69 sqlite3=3.27.2-3 \
    php-xml=2:7.3+69 \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY ./docker/nginx/custom-default  /etc/nginx/sites-available/default
COPY ./docker/nginx/certificate.crt /etc/ssl/certificate.crt
COPY ./docker/nginx/private.key     /etc/ssl/private.key
COPY ./docker/php/custom-www.conf   /etc/php/7.3/fpm/pool.d/www.conf
COPY ./docker/php/custom-php.ini    /etc/php/7.3/cli/php.ini
COPY ./                             /var/www
COPY ./docker/build.sh              /
RUN chmod +x /build.sh
CMD ["/build.sh"]