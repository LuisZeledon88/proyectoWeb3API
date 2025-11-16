#!/bin/sh

export PHPRC=/app

php -S 0.0.0.0:$PORT -t ./api
