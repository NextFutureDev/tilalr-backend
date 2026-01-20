@echo off
echo Installing Laravel dependencies...
composer install --optimize-autoloader --no-dev

echo Clearing caches...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo Optimizing for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo Dependencies installed successfully!
pause
