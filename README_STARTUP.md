# 🚀 Quick Start Guide - TilRimal Local Development

## Problem You're Facing
```
[IslandDestinationsLocal] Fetch error: "Failed to fetch"
```
**Cause:** Backend server is NOT running on port 8000

---

## Solution: Start Backend Server

### **Option 1: Simple (Recommended)**
Double-click this file:
```
c:\xampp\htdocs\tilrimal-backend\START_SERVER.bat
```
✓ Server starts on http://127.0.0.1:8000

### **Option 2: Manual Commands**
```bash
# Terminal 1 - Backend
cd c:\xampp\htdocs\tilrimal-backend
php artisan serve --host=127.0.0.1 --port=8000

# Wait for output: "Server running on http://127.0.0.1:8000"
```

---

## Seed Database (ONE-TIME ONLY)

After backend starts, run this:
```bash
# Terminal 2
cd c:\xampp\htdocs\tilrimal-backend
php artisan db:seed --class=IslandDestinationsLocalSeeder
```

Or just double-click:
```
c:\xampp\htdocs\tilrimal-backend\SEED_DATABASE.bat
```

✓ Should output: `✅ Local Island Destinations Seeded Successfully!`

---

## Start Frontend

```bash
# Terminal 3
cd c:\xampp\htdocs\tilrimal-frontend
npm run dev
```

✓ Server starts on http://localhost:3000

---

## Verify It Works

### Test 1: Check Backend is Running
```
http://127.0.0.1:8000/api/island-destinations/local
```
Should return JSON with 3 islands

### Test 2: Check Frontend Loads
```
http://localhost:3000/en/local-islands
```
Should show 3 island cards

### Test 3: Check Browser Console
- Open DevTools (F12)
- Go to **Console** tab
- Should see:
```
[IslandDestinationsLocal] Fetching from: http://127.0.0.1:8000/api/island-destinations/local
[IslandDestinationsLocal] Response status: 200
[IslandDestinationsLocal] Loaded destinations count: 3
```

---

## Complete Startup (Automated)

Double-click this to start everything:
```
c:\xampp\htdocs\tilrimal-backend\START_ALL.bat
```

Then choose option 5 to start both servers

---

## Troubleshooting

| Symptom | Fix |
|---------|-----|
| "Failed to fetch" in console | Run `START_SERVER.bat` or `php artisan serve --host=127.0.0.1 --port=8000` |
| Empty island list | Run `SEED_DATABASE.bat` or `php artisan db:seed --class=IslandDestinationsLocalSeeder` |
| `netstat shows port 8000 not listening` | Backend crashed, check for Laravel errors |
| `npm: command not found` | Node.js not installed or not in PATH |
| Browser shows "Cannot connect to server" | Both servers need to be running |

---

## Files You Have

- **START_SERVER.bat** - Starts backend only
- **SEED_DATABASE.bat** - Seeds database with test data
- **START_ALL.bat** - Interactive menu to start/seed everything

---

## Expected Result ✓

1. 3 island cards on /local-islands page
2. Click card → Detail page loads
3. Click "Book Now" → Booking modal opens (if logged in)
4. Complete booking → Payment gateway (test mode)

---

**Everything is ready! Just need to start the servers!** 🎉
