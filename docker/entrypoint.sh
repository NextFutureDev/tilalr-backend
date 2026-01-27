#!/bin/sh
set -e

echo "🚀 Starting Tilalr Backend..."

# Create necessary directories
mkdir -p /var/log/supervisor
mkdir -p /var/log/php
mkdir -p /var/log/nginx

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
max_tries=30
counter=0
while ! php artisan db:monitor --databases=mysql 2>/dev/null; do
    counter=$((counter + 1))
    if [ $counter -gt $max_tries ]; then
        echo "❌ Database connection failed after $max_tries attempts"
        break
    fi
    echo "Waiting for database... attempt $counter/$max_tries"
    sleep 2
done

# Run migrations if AUTO_MIGRATE is set
if [ "${AUTO_MIGRATE:-false}" = "true" ]; then
    echo "📦 Running database migrations..."
    php artisan migrate --force
fi

# Clear and cache configurations for production
echo "🔧 Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage link if not exists
if [ ! -L /var/www/html/public/storage ]; then
    echo "🔗 Creating storage link..."
    php artisan storage:link
fi

# Set correct permissions
echo "🔐 Setting permissions..."
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "✅ Application ready!"
echo "🌐 Starting services..."

# Start supervisor (manages nginx, php-fpm, queue workers)
exec /usr/bin/supervisord -c /etc/supervisord.conf
