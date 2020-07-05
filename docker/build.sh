#!/bin/bash

php ./docker/mock/login-redis.php

# Comando
/etc/init.d/php7.3-fpm start && nginx -g "daemon off;"