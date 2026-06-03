#!/bin/bash
# Render.com start script

php artisan migrate --force
php artisan storage:link || true
php artisan serve --host=0.0.0.0 --port=$PORT
