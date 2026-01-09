# Debug Steps for Page Expired Issue

## 1. Check Browser Network Tab
1. Open `http://localhost:8000/admin`
2. Open DevTools (F12)
3. Go to Network tab
4. Try to create/submit a form (e.g., create an offer)
5. **Look for a request that returns 419 status code**
6. Click on that 419 request and check:
   - Headers → Request Headers (look for `X-CSRF-TOKEN` or `_token`)
   - Headers → Response Headers (look for `X-CSRF-TOKEN`)
   - Response body (might show the error)

## 2. Check Browser Console
1. Open DevTools (F12)
2. Go to Console tab  
3. Try the form submission again
4. Look for any error messages or JavaScript errors

## 3. Check Laravel Logs
Run this command to watch logs in real-time:
```bash
cd c:\xampp\htdocs\tilrimal-backend
tail -f storage/logs/laravel.log
```

Or check the latest log file:
```bash
cd c:\xampp\htdocs\tilrimal-backend
type storage\logs\laravel.log | tail -20
```

## 4. Check Sessions in Database
Open your MySQL/database client and run:
```sql
SELECT COUNT(*) as total_sessions FROM sessions;
SELECT * FROM sessions ORDER BY last_activity DESC LIMIT 5;
```

## What to Report
Please provide:
1. Screenshot of DevTools Network tab showing the 419 request
2. The exact URL/path of the request that fails
3. Full response body of the 419 error
4. Any errors in Console tab
5. Latest entries from `storage/logs/laravel.log`

This information will help identify the exact cause of the CSRF mismatch.
