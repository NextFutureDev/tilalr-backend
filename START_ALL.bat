@echo off
REM Complete TilRimal Startup Script
REM Starts both backend and frontend servers

setlocal enabledelayedexpansion

echo.
echo ╔════════════════════════════════════════════════════════════════════════════════╗
echo ║                    TilRimal Development Environment Startup                     ║
echo ╚════════════════════════════════════════════════════════════════════════════════╝
echo.

echo Choose what you want to do:
echo.
echo 1) Start Backend Server Only
echo 2) Seed Database (run ONCE after backend starts)
echo 3) Start Frontend Server Only
echo 4) Test Backend API (check if running)
echo 5) Start BOTH (requires 2 terminals)
echo.

set /p choice="Enter your choice (1-5): "

if "%choice%"=="1" goto start_backend
if "%choice%"=="2" goto seed_database
if "%choice%"=="3" goto start_frontend
if "%choice%"=="4" goto test_api
if "%choice%"=="5" goto start_both
goto invalid

:start_backend
cls
echo.
echo ========================================
echo Starting Backend Server...
echo ========================================
echo.
cd /d c:\xampp\htdocs\tilrimal-backend
php artisan serve --host=127.0.0.1 --port=8000
goto end

:seed_database
cls
echo.
echo ========================================
echo Seeding Database...
echo ========================================
echo.
cd /d c:\xampp\htdocs\tilrimal-backend
php artisan db:seed --class=IslandDestinationsLocalSeeder
if %errorlevel% equ 0 (
    echo.
    echo ✓ Database seeded successfully!
    echo.
    echo Next steps:
    echo 1. Backend should still be running (if not, run option 1)
    echo 2. Start Frontend: Option 3
    echo 3. Open http://localhost:3000/en/local-islands in browser
) else (
    echo.
    echo ✗ Seeding failed!
)
pause
goto menu

:start_frontend
cls
echo.
echo ========================================
echo Starting Frontend Server...
echo ========================================
echo.
cd /d c:\xampp\htdocs\tilrimal-frontend
call npm run dev
goto end

:test_api
cls
echo.
echo Testing Backend API...
echo.
cd /d c:\xampp\htdocs\tilrimal-frontend
powershell -Command "try { $response = Invoke-WebRequest -Uri 'http://127.0.0.1:8000/api/island-destinations/local' -Method Get -TimeoutSec 5 -ErrorAction Stop; if ($response.StatusCode -eq 200) { Write-Host '✓ Backend is responding!' -ForegroundColor Green; Write-Host '✓ Status: 200' -ForegroundColor Green; $json = $response.Content | ConvertFrom-Json; Write-Host ('✓ Data loaded: ' + $json.data.Count + ' islands') -ForegroundColor Green } } catch { Write-Host '✗ Cannot connect to backend' -ForegroundColor Red; Write-Host ('✗ Error: ' + $_.Exception.Message) -ForegroundColor Red }"
echo.
pause
goto menu

:start_both
cls
echo.
echo ========================================
echo Starting BOTH Backend and Frontend
echo ========================================
echo.
echo This will open 2 new command windows.
echo Close them to stop the servers.
echo.

REM Start backend in new window
start "TilRimal Backend Server" cmd /k "cd /d c:\xampp\htdocs\tilrimal-backend && php artisan serve --host=127.0.0.1 --port=8000"

REM Wait for backend to start
timeout /t 3 /nobreak

REM Start frontend in new window
start "TilRimal Frontend Server" cmd /k "cd /d c:\xampp\htdocs\tilrimal-frontend && npm run dev"

echo.
echo ✓ Both servers starting in separate windows...
echo ✓ Backend: http://127.0.0.1:8000
echo ✓ Frontend: http://localhost:3000
echo.
echo Next steps:
echo 1. Wait 10 seconds for both to fully start
echo 2. Run option 2 (Seed Database) if not done yet
echo 3. Open http://localhost:3000/en/local-islands in browser
echo.
pause
goto end

:invalid
cls
echo Invalid choice. Please try again.
pause
goto menu

:menu
cls
goto choice

:end
