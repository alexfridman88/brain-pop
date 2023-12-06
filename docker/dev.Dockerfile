# syntax=docker/dockerfile:1
FROM montebal/laradev:php80-2204 as dev


COPY ../vendor /var/www/html/vendor
RUN if [ -d "/var/www/html/storage" ]; then chmod -R 777 /var/www/html/storage; fi
