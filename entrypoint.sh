#!/bin/sh

composer install

php command migrate

exec "$@"