@echo off
setlocal enabledelayedexpansion

title TilRimal Diagnostic - Check System Status

echo.
echo ====================================================
echo   TILRIMAL LOCAL DEVELOPMENT - DIAGNOSTIC CHECK
echo ====================================================
echo.

REM Check if ports are listening
echo [1/4] Checking ports...
echo.

REM Check port 3306 (MySQL)
netstat -ano | findstr "3306" >nul 2>&1
if !errorlevel! equ 0 (
    echo ✓ MySQL is running on port 3306
) else (
    echo ✗ MySQL is NOT running on port 3306
    echo   Action: Start XAMPP control panel and start MySQL
)

REM Check port 8000 (Backend)
netstat -ano | findstr "8000" >nul 2>&1
if !errorlevel! equ 0 (
    echo ✓ Backend server is running on port 8000
) else (
    echo ✗ Backend server is NOT running on port 8000
    echo   Action: Run START_SERVER.bat in tilrimal-backend folder
)

REM Check port 3000 (Frontend)
netstat -ano | findstr "3000" >nul 2>&1
if !errorlevel! equ 0 (
    echo ✓ Frontend dev server is running on port 3000
) else (
    echo ✗ Frontend dev server is NOT running on port 3000
    echo   Action: Run "npm run dev" in tilrimal-frontend folder
)

echo.
echo [2/4] Checking file permissions...

if exist "c:\xampp\htdocs\tilrimal-backend\composer.json" (
    echo ✓ Backend composer.json found
) else (
    echo ✗ Backend composer.json NOT found
)

if exist "c:\xampp\htdocs\tilrimal-frontend\package.json" (
    echo ✓ Frontend package.json found
) else (
    echo ✗ Frontend package.json NOT found
)

echo.
echo [3/4] Checking key directories...

if exist "c:\xampp\htdocs\tilrimal-backend\storage\logs" (
    echo ✓ Backend logs directory exists
) else (
    echo ✗ Backend logs directory missing
)

if exist "c:\xampp\htdocs\tilrimal-backend\bootstrap\cache" (
    echo ✓ Backend cache directory exists
) else (
    echo ✗ Backend cache directory missing
)

echo.
echo [4/4] Summary:
echo.

netstat -ano | findstr "8000" >nul 2>&1
if !errorlevel! equ 0 (
    echo ✓ All systems ready! Your data should load now.
    echo.
    echo Next steps:
    echo   1. Open browser: http://localhost:3000/en/local-islands
    echo   2. Check browser DevTools (F12) -^> Console tab
    echo   3. Look for debug logs showing loaded destinations
) else (
    echo ✗ Backend is NOT running
    echo.
    echo To fix:
    echo   1. Open command prompt or PowerShell
    echo   2. Run: cd c:\xampp\htdocs\tilrimal-backend
    echo   3. Run: php artisan serve --host=127.0.0.1 --port=8000
    echo   4. Wait for "Server running on http://127.0.0.1:8000"
    echo   5. Visit http://localhost:3000/en/local-islands
)

echo.
echo ====================================================
echo.
pause
