#!/bin/bash

source .env
docker-compose up -d --build
docker-compose exec php bash -c "composer self-update"
docker-compose exec php bash -c "cd /var/www/app && composer install && ./yii migrate"
