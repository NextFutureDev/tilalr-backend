## 🔐 Admin Login Credentials

### Login Information:
- **Email:** `admin@tilrimal.com`
- **Password:** `password123`

---

## 📍 Access Points

### Option 1: API Authentication (Current Setup)
Currently, your API endpoints are **open** (no authentication required). You can:

1. **Test API directly:**
   ```bash
   # Get all data
   curl http://localhost:8000/api/services?lang=ar
   curl http://localhost:8000/api/trips?lang=ar
   
   # Create new service
   curl -X POST http://localhost:8000/api/admin/services \
     -H "Content-Type: application/json" \
     -d '{"title":"خدمة جديدة","slug":"new-service","lang":"ar","is_active":true}'
   ```

2. **Use from Next.js:**
   ```javascript
   import api from '@/lib/api';
   
   // Create service
   await api.createService({
     title: 'خدمة جديدة',
     slug: 'new-service',
     lang: 'ar',
     is_active: true
   });
   ```

### Option 2: Create Simple Admin Panel

You can create a basic admin interface in Laravel:

**Run this command:**
```bash
cd C:\xampp\htdocs\tilrimal-backend
php artisan make:controller Admin/DashboardController
```

---

## 🔒 Adding Authentication (Recommended Next Step)

### Install Laravel Sanctum for API Authentication:

```bash
cd C:\xampp\htdocs\tilrimal-backend
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### Add Login Endpoint:

Create `app/Http/Controllers/Api/AuthController.php`:
```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            
            return response()->json([
                'user' => $user,
                'token' => $token
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
```

Add to `routes/api.php`:
```php
Route::post('/login', [AuthController::class, 'login']);
```

---

## 🎯 Quick Database Check

**Verify admin user exists:**
```bash
php artisan tinker
```
```php
User::where('email', 'admin@tilrimal.com')->first();
```

**Check seeded data:**
```bash
# Open in browser
http://localhost:8000/api/services?lang=ar
http://localhost:8000/api/cities?lang=ar
http://localhost:8000/api/trips?lang=ar
```

---

## 📊 What's Been Seeded

✅ **Admin User:** admin@tilrimal.com / password123
✅ **2 Services** (Arabic & English)
✅ **2 Cities** (Riyadh, Jeddah)
✅ **2 Trips** (linked to cities)
✅ **1 Product** (Umrah package)
✅ **2 Testimonials** (customer reviews)
✅ **1 Team Member**
✅ **5 Settings** (site config)

---

## 🚀 Test Your Data

**PowerShell:**
```powershell
# View services
Invoke-RestMethod "http://localhost:8000/api/services?lang=ar"

# View trips with cities
Invoke-RestMethod "http://localhost:8000/api/trips?lang=ar"

# View testimonials
Invoke-RestMethod "http://localhost:8000/api/testimonials?lang=ar"
```

**Browser:**
- http://localhost:8000/api/services?lang=ar
- http://localhost:8000/api/trips?lang=ar
- http://localhost:8000/api/cities?lang=ar

---

**Your admin credentials are ready and sample data has been loaded!** 🎉
