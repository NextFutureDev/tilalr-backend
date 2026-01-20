@echo off
REM Start TilRimal Backend Server
REM This script starts the Laravel development server

echo.
echo ========================================
echo TilRimal Backend Server Startup
echo ========================================
echo.

cd /d c:\xampp\htdocs\tilrimal-backend

REM Check if .env exists
if not exist .env (
    echo ✗ ERROR: .env file not found
    echo Creating .env from .env.example...
    copy .env.example .env
)

REM Generate app key if needed
php artisan key:generate 2>nul

REM Clear any cached files
echo Clearing cache...
php artisan cache:clear 2>nul
php artisan config:clear 2>nul
php artisan route:clear 2>nul

REM Start the server
echo.
echo Starting Laravel development server...
echo Server will run on: http://127.0.0.1:8000
echo.
echo To stop the server, press Ctrl+C
echo.

php artisan serve --host=127.0.0.1 --port=8000

pause
