# 🚀 Laravel Backend Deployment Handoff
**Project:** TilRimal Admin Backend  
**Server:** Hostinger (141.136.39.68:65002)  
**Domain:** admin.tilalr.com  
**Frontend:** tilalr.com (Vercel)  
**Status:** Ready to deploy — needs PHP version fix & CORS update  

---

## 📋 Current State (Verified)

### ✅ What's Already Set
- **composer.json** requires `php: ^8.2` (good for most hosts)
- **.env** has production values configured:
  - `APP_URL=https://admin.tilalr.com`
  - `FRONTEND_URL=https://tilalr.com`
  - `DB_CONNECTION=mysql` with Hostinger credentials set
  - `APP_ENV=production` and `APP_DEBUG=false`
- **routes/api.php** has health check, auth, and public API endpoints
- **config/cors.php** uses `env('FRONTEND_URL')` for allowed origins ✅

### ⚠️ Issues to Fix Before Going Live

1. **PHP Version Mismatch** (Critical)
   - Hostinger may be on PHP 8.3 but composer.json specifies `^8.2`
   - Need to create `.user.ini` with `zend.exception_handler` and version override if needed
   - Or update composer.json to `^8.3` if host is on 8.3

2. **CORS Configuration** (Critical)
   - `config/cors.php` uses `env('FRONTEND_URL')` which evaluates to `https://tilalr.com`
   - This is correct ✅
   - But you must run `php artisan config:cache` after deploying to apply changes

3. **Database Connection** (Verify on Server)
   - Credentials in `.env` are for Hostinger MySQL
   - Must verify database exists and user has proper permissions
   - Run `php artisan migrate --force` after upload

4. **Storage Symlink** (Required)
   - Must run `php artisan storage:link` on server
   - Creates symlink from `public/storage` to `storage/app/public`

5. **Writable Directories** (Required)
   - `storage/` must be writable (chmod 775 or 755)
   - `bootstrap/cache/` must be writable
   - Set via SSH or cPanel File Manager

---

## 🔧 Critical Files Summary

### composer.json
- **Current:** `"php": "^8.2"`
- **Action:** If host is PHP 8.3+, change to `"php": "^8.3"` and run `composer update`
- **Location:** Line 8

### .env
- **APP_URL:** ✅ `https://admin.tilalr.com`
- **FRONTEND_URL:** ✅ `https://tilalr.com`
- **DB credentials:** ✅ Set (u710227726_tilalrimal)
- **Action:** Verify database exists on host and user can connect

### config/cors.php
- **allowed_origins:** Uses `env('FRONTEND_URL')` = `https://tilalr.com` ✅
- **Action:** After upload, run `php artisan config:cache`

### routes/api.php
- **Health checks:** ✅ `/api/health` and `/api/health/db`
- **Public endpoints:** ✅ Trips, cities, pages, services, products
- **Auth endpoints:** ✅ Register and login
- **Action:** No changes needed

---

## 📝 Step-by-Step Deployment Checklist

### 1️⃣ Pre-Upload (Local)
- [ ] Ensure composer.json PHP version matches host (check Hostinger hosting panel)
- [ ] Run: `composer install --optimize-autoloader --no-dev`
- [ ] Verify `.env` has correct `APP_URL=https://admin.tilalr.com`
- [ ] Zip project: `C:\xampp\htdocs\tilrimal-backend`

### 2️⃣ Upload to Server (SSH or cPanel File Manager)
```bash
# Option A: Via SSH and Git (if repo is private)
git clone <your-repo> /home/u710227726/admin-app

# Option B: Upload ZIP via cPanel File Manager
# Upload to /home/u710227726/ and extract → folder named "admin-app"
```

### 3️⃣ SSH into Server & Deploy
```bash
ssh -p 65002 u710227726@141.136.39.68

# Navigate to project
cd /home/u710227726/admin-app

# Install dependencies
composer install --optimize-autoloader --no-dev

# Generate/verify app key
php artisan key:generate --ansi

# Setup database
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R u710227726:www-data storage bootstrap/cache 2>/dev/null || true

# Clear & cache config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Verify health check
curl https://admin.tilalr.com/api/health
```

### 4️⃣ hPanel Configuration
- [ ] Set Document Root to `/home/u710227726/admin-app/public`
- [ ] Enable SSL (Let's Encrypt auto)
- [ ] Force HTTPS in `.htaccess` (if needed)

### 5️⃣ Verify CORS & API
```bash
# From your PC (PowerShell)
curl -I https://admin.tilalr.com
curl -v -H "Origin: https://tilalr.com" https://admin.tilalr.com/api/health 2>&1 | Select-String "access-control"
```

### 6️⃣ Check Logs for Errors
```bash
ssh -p 65002 u710227726@141.136.39.68
tail -f /home/u710227726/admin-app/storage/logs/laravel.log
```

---

## 🔴 Common Issues & Fixes

| Issue | Cause | Fix |
|-------|-------|-----|
| 500 Error | Missing PHP extension or version | Check logs; verify PHP version in hPanel |
| CORS blocked | `allowed_origins` doesn't include frontend | Run `php artisan config:cache` |
| Database connection error | Wrong credentials or DB doesn't exist | Verify DB exists; check `.env` credentials |
| Storage link fails | Permission denied | Run `chmod -R 775 storage` |
| Config not updating | Old cache | Run `php artisan config:clear && config:cache` |
| Symlink denied | Hosting doesn't allow symlinks | Use `storage:link --relative` (Laravel 11+) |

---

## 📞 Quick Reference Commands

```bash
# SSH login
ssh -p 65002 u710227726@141.136.39.68

# Check PHP version
php -v

# Check PHP modules
php -m | grep -E '(openssl|pdo|mbstring|tokenizer|xml|ctype|json|bcmath)'

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo()
>>> exit

# View logs
tail -n 200 /home/u710227726/admin-app/storage/logs/laravel.log

# Force cache clear (if stuck)
rm -rf bootstrap/cache/*
php artisan config:cache

# Test API from server
curl -s https://admin.tilalr.com/api/health | php -r 'echo json_encode(json_decode(file_get_contents("php://stdin")), JSON_PRETTY_PRINT);'
```

---

## ✅ Deployment Complete When:
- [ ] `curl https://admin.tilalr.com/api/health` returns `{"status":"ok"}`
- [ ] CORS header shows: `access-control-allow-origin: https://tilalr.com`
- [ ] Frontend can fetch from API without errors
- [ ] Database migrations ran successfully
- [ ] Storage symlink created (`ls -la public/storage`)
- [ ] Logs show no errors (`storage/logs/laravel.log`)

---

## 🎯 Next Steps (For AI/Developer)
1. Verify Hostinger PHP version (check hPanel)
2. If PHP 8.3: Update composer.json to `^8.3` and reinstall
3. Upload project via Git clone or ZIP + extract
4. Run the SSH deployment commands above
5. Test API endpoints and CORS from frontend
6. Monitor logs for 24 hours

**Contact:** If 500 errors persist, check `storage/logs/laravel.log` for specific error and share the output.
