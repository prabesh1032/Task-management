#!/bin/sh
set -e

cd /var/www/html

echo "Generating app key if not set..."
php artisan key:generate --no-interaction --force 2>/dev/null || true

echo "Running migrations..."
php artisan migrate --force --no-interaction

echo "Caching config, routes, views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Creating storage link..."
php artisan storage:link --force 2>/dev/null || true

echo "Patching nginx port to $PORT..."
sed -i "s/NGINX_PORT/${PORT:-8080}/g" /etc/nginx/nginx.conf

echo "Starting services..."
mkdir -p /var/log/supervisor
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
