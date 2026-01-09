@echo off
REM Create test users via API
curl -X POST http://127.0.0.1:8000/api/test-data/create-users ^
  -H "Content-Type: application/json" ^
  -d "{}" ^
  -v > test_users_result.txt 2>&1
echo.
echo Results saved to test_users_result.txt
type test_users_result.txt
