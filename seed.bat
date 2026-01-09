@echo off
cd C:\xampp\mysql\bin
mysql -u root tilrimal < "C:\xampp\htdocs\tilrimal-backend\insert_intl_islands.sql"
echo.
echo ========================================
echo Island seeding complete!
echo ========================================
pause
