@echo off
setlocal enabledelayedexpansion

title TilRimal Backend - Start & Seed

cd /d c:\xampp\htdocs\tilrimal-backend

echo.
echo ====================================================
echo   TILRIMAL BACKEND - STARTUP & SEED
echo ====================================================
echo.

REM Clear cache
echo [Step 1/4] Clearing cache and config...
call php artisan config:clear >nul 2>&1
call php artisan cache:clear >nul 2>&1
echo ✓ Cache cleared

REM Check database connection
echo [Step 2/4] Testing database connection...
php artisan tinker <<EOF
\$test = DB::connection()->getPdo();
echo "✓ Database connection OK\n";
exit;
EOF

if !errorlevel! neq 0 (
    echo ✗ Database connection failed!
    echo Check MySQL is running in XAMPP
    pause
    exit /b 1
)

REM Run migrations
echo [Step 3/4] Running migrations...
call php artisan migrate --force >nul 2>&1
echo ✓ Migrations complete

REM Seed database
echo [Step 4/4] Seeding database...
call php artisan db:seed --class=IslandDestinationsLocalSeeder >nul 2>&1
echo ✓ Database seeded

echo.
echo ====================================================
echo   SERVER STARTING - Listen on http://127.0.0.1:8000
echo ====================================================
echo.
echo Press Ctrl+C to stop the server
echo.

REM Start server
php artisan serve --host=127.0.0.1 --port=8000

pause
