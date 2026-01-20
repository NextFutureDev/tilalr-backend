# 🐛 DEBUGGING IMAGE UPLOAD - STEP BY STEP

## What We Need to Know

When you try to upload an image in the admin panel, **what exactly happens?**

Choose one:

1. **Button doesn't respond** - I click upload, nothing happens
2. **Button spins** - I see loading spinner, then it disappears
3. **Error message appears** - Red message shows up
4. **Image saves but shows NULL** - Upload completes, but image column stays NULL
5. **Looks uploaded, but 404 on frontend** - Image seems to save, but can't display
6. **Something else** - Different error

---

## Diagnostic Steps

### For All Cases:

**Step 1:** Open browser console
```
Press F12
Click "Console" tab
```

**Step 2:** Try uploading image
```
Go to: http://localhost:8000/admin
Edit an island (ID 13, 14, or 15)
Click image upload area
Select a JPG or PNG file
Click Save
```

**Step 3:** Check console for errors
```
Look for red error messages
Copy any error text
```

**Step 4:** Check Laravel logs
```
Open: storage/logs/laravel.log
Look for entries with ERROR in them
Copy relevant error messages
```

**Step 5:** Send me:
- What happened (one of the 6 options above)
- Console error message (if any)
- Laravel log error message (if any)
- The image file you tried to upload (size, format, name)

---

## Common Issues & Quick Fixes

### Issue 1: "413 Request Entity Too Large"
**Fix:**
Edit `php.ini`:
```ini
post_max_size = 100M
upload_max_filesize = 100M
```

### Issue 2: "CSRF token mismatch"
**Fix:**
```bash
php artisan cache:clear
```

### Issue 3: "Permission denied"
**Fix:**
```
Right-click storage folder
Properties → Security
Add user with Full Control
```

### Issue 4: "Symlink error"
**Fix:**
```bash
php artisan storage:link
```

---

## Quick Test

Run this to verify backend is ready:

```bash
php quick_test.php
```

Expected output:
```
Islands folder: ...storage/app/public/islands
Exists: YES
Writable: YES
Permissions: 0777
✅ File write works
```

---

## What I Need From You

**Tell me what error/message you see when uploading, and I'll fix it!**

Use browser console (F12) to copy the exact error.
