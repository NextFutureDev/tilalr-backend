# Quick Diagnostic & Fix Guide

## Issue: Data not fetching from API

Follow these steps to diagnose and fix:

---

## 1. **Verify Backend is Running**

```bash
# In a terminal at the backend folder:
cd c:\xampp\htdocs\tilrimal-backend

# Check if Laravel server is running
php artisan serve

# Expected output:
# INFO  Server running on http://127.0.0.1:8000
```

**✅ If you see this, backend is ready.**

---

## 2. **Seed the Database (One-time)**

```bash
# In the same terminal:
php artisan db:seed --class=IslandDestinationsLocalSeeder

# Expected output:
# ✅ Local Island Destinations Seeded Successfully! (Only 3 AlUla Trips)
```

---

## 3. **Test the API Endpoint Directly**

Open your browser and visit:
```
http://127.0.0.1:8000/api/island-destinations/local
```

**You should see a JSON response like:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "slug": "trip-to-alula",
      "title_en": "Trip to AlUla",
      "title_ar": "رحلة العلا يوم واحد",
      ...
    }
  ],
  "message": "Island destinations retrieved successfully"
}
```

**If you see an error:**
- Check error message in the response
- Verify database has data: `SELECT COUNT(*) FROM island_destinations WHERE type='local';`
- Check Laravel logs: `storage/logs/laravel.log`

---

## 4. **Start Frontend in Dev Mode**

```bash
# In a NEW terminal at the frontend folder:
cd c:\xampp\htdocs\tilrimal-frontend

npm run dev

# Expected output:
# ▲ Next.js 16.0.10
# - Local:        http://localhost:3000
```

---

## 5. **Check Browser Console for Errors**

1. Open browser DevTools (F12)
2. Go to **Console** tab
3. Visit http://localhost:3000/en/local-islands
4. Look for logs like:
   ```
   [IslandDestinationsLocal] Fetching from: http://127.0.0.1:8000/api/island-destinations/local
   [IslandDestinationsLocal] Response status: 200
   [IslandDestinationsLocal] Loaded destinations count: 3
   ```

**✅ If you see these logs with count > 0, data is loading!**

---

## 6. **Common Issues & Fixes**

| Issue | Fix |
|-------|-----|
| `Failed to fetch` | Backend not running. Run `php artisan serve` |
| `CORS error` | Check backend `.env` has `APP_URL=http://127.0.0.1:8000` |
| `API error: 404` | Route not registered. Check `routes/api.php` has `/island-destinations/local` |
| `Empty data array []` | Database not seeded. Run `php artisan db:seed --class=IslandDestinationsLocalSeeder` |
| Hydration warning | ✅ Already fixed with `suppressHydrationWarning` on body tag |

---

## 7. **Full End-to-End Test**

```bash
# Terminal 1 - Backend
cd c:\xampp\htdocs\tilrimal-backend
php artisan serve

# Terminal 2 - Frontend  
cd c:\xampp\htdocs\tilrimal-frontend
npm run dev

# Then in browser:
# 1. Visit http://localhost:3000/en/local-islands
# 2. Check console for [IslandDestinationsLocal] logs
# 3. You should see 3 island cards loaded
# 4. Click one → detail page should load
# 5. Click "Book Now" → Booking modal should open
```

---

## 8. **If Still Not Working**

Collect this info and share:

```bash
# In backend folder:
echo "=== API Response ==="
curl -s http://127.0.0.1:8000/api/island-destinations/local | jq .

# In backend folder:
echo "=== Database Count ==="
php artisan tinker
>>> IslandDestination::count();

# In browser console:
console.log(localStorage.getItem('auth_token'))
```

---

## Quick Commands Reference

```bash
# Backend server
php artisan serve

# Seed database
php artisan db:seed --class=IslandDestinationsLocalSeeder

# Clear cache
php artisan cache:clear
php artisan config:clear

# Frontend dev
npm run dev

# Frontend build
npm run build

# Check if port is open
netstat -ano | find "8000"   # Windows
lsof -i :8000                  # Mac/Linux
```

---

**✅ After these steps, the island destinations should load and you can book a trip!**
