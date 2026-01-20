@echo off
setlocal enabledelayedexpansion

title TilRimal Backend Server - Starting...

cd /d c:\xampp\htdocs\tilrimal-backend

echo.
echo ====================================================
echo   TILRIMAL BACKEND SERVER
echo ====================================================
echo.
echo Starting Laravel development server...
echo Server URL: http://127.0.0.1:8000
echo Database: MySQL on localhost:3306
echo.
echo Press Ctrl+C to stop the server
echo ====================================================
echo.

REM Clear cache before starting
echo [1/3] Clearing cache...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1

REM Verify database connection
echo [2/3] Checking database connection...
php artisan tinker <<EOF
exit;
EOF

echo [3/3] Starting server on 127.0.0.1:8000...
echo.

REM Start the server
php artisan serve --host=127.0.0.1 --port=8000

echo.
echo Server stopped.
pause
