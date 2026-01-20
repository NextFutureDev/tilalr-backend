@echo off
REM Seed Island Destinations
REM Run this ONCE to populate the database with test data

echo.
echo ========================================
echo TilRimal Database Seeder
echo ========================================
echo.

cd /d c:\xampp\htdocs\tilrimal-backend

echo Seeding Island Destinations...
php artisan db:seed --class=IslandDestinationsLocalSeeder

if %errorlevel% equ 0 (
    echo.
    echo ✓ Success! Database has been seeded with 3 island destinations.
) else (
    echo.
    echo ✗ Error: Seeding failed
    echo Check that MySQL is running and database exists
)

echo.
pause
