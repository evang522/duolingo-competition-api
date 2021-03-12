web: vendor/bin/heroku-php-nginx -C public/nginx.conf public/
release: php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration --query-time --all-or-nothing
