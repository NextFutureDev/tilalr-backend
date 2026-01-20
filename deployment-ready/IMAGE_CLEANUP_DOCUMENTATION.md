# 🗑️ Image Cleanup System Documentation

## 🎯 **Overview**

The Sensing Nature application now includes an automatic image cleanup system that prevents orphaned image files from accumulating in your storage directory. This system automatically deletes image files when:

1. **Records are deleted** from the database
2. **Images are updated/replaced** with new ones
3. **Models are soft-deleted** (if implemented)

## 🏗️ **Architecture**

### **HasImageCleanup Trait**
The system is built around a reusable trait (`app/Traits/HasImageCleanup.php`) that can be applied to any model with image fields.

### **Automatic Event Handling**
The trait automatically hooks into Laravel's model events:
- `deleted` - Cleans up images when records are deleted
- `updated` - Cleans up old images when they're replaced

## 📁 **Supported Models**

| Model | Image Fields | Storage Path |
|-------|--------------|--------------|
| **TeamMember** | `image` | `storage/app/public/team-members/images/` |
| **Project** | `image` | `storage/app/public/projects/images/` |
| **Portfolio** | `image` | `storage/app/public/portfolio/` |
| **Service** | `icon` | `storage/app/public/services/icons/` |

## 🔧 **How It Works**

### **1. Automatic Cleanup on Deletion**
```php
// When a TeamMember is deleted
$teamMember = TeamMember::find(1);
$teamMember->delete(); // Automatically deletes the image file
```

### **2. Automatic Cleanup on Update**
```php
// When a TeamMember's image is updated
$teamMember = TeamMember::find(1);
$teamMember->update(['image' => 'new-image.jpg']); // Old image is automatically deleted
```

### **3. Smart Field Detection**
The trait automatically detects these image field names:
- `image`
- `icon`
- `photo`
- `picture`

## 🛡️ **Safety Features**

### **Error Handling**
- **Graceful degradation**: If image deletion fails, the main operation continues
- **Comprehensive logging**: All operations are logged for debugging
- **Fallback deletion**: Uses both Storage facade and direct file deletion

### **File Validation**
- Checks if files exist before attempting deletion
- Validates file paths to prevent security issues
- Handles null/empty image paths safely

## 📊 **Logging**

All image cleanup operations are logged with detailed information:

```php
// Successful deletion
Log::info("Deleted image file from storage disk: team-members/images/photo.jpg", [
    'model' => 'TeamMember',
    'field' => 'image'
]);

// Failed deletion
Log::warning("Failed to delete image file: team-members/images/photo.jpg", [
    'error' => 'Permission denied',
    'model' => 'TeamMember',
    'field' => 'image'
]);
```

## 🚀 **Usage Examples**

### **Adding to New Models**
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImageCleanup;

class NewModel extends Model
{
    use HasImageCleanup;
    
    protected $fillable = ['name', 'image'];
}
```

### **Customizing Image Fields**
```php
class CustomModel extends Model
{
    use HasImageCleanup;
    
    // Override default image fields
    protected function getImageFields(): array
    {
        return ['image', 'thumbnail', 'banner'];
    }
}
```

## 🔍 **Testing the System**

### **Manual Testing**
1. **Create a record** with an image
2. **Update the image** - old file should be deleted
3. **Delete the record** - image file should be deleted

### **Verification Commands**
```bash
# Check if trait is properly integrated
php artisan tinker
>>> $model = new App\Models\TeamMember();
>>> method_exists($model, 'cleanupImages'); // Should return true
```

## 📋 **Configuration**

### **Environment Variables**
No additional environment variables are required. The system uses:
- `FILESYSTEM_DISK=public` (from Laravel config)
- Default storage path: `storage/app/public/`

### **Storage Disk Configuration**
```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

## 🚨 **Troubleshooting**

### **Common Issues**

#### **Images Not Being Deleted**
1. Check if the model uses the `HasImageCleanup` trait
2. Verify file permissions on storage directory
3. Check Laravel logs for error messages

#### **Permission Errors**
```bash
# Fix storage permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### **Storage Link Issues**
```bash
# Recreate storage link
php artisan storage:link
```

### **Debug Mode**
Enable debug logging to see detailed cleanup operations:
```php
// In .env
LOG_LEVEL=debug
```

## 🔄 **Migration from Old System**

If you previously had manual image cleanup:

1. **Remove old cleanup code** from models/controllers
2. **Add the trait** to your models
3. **Test thoroughly** to ensure no regressions
4. **Monitor logs** for the first few days

## 📈 **Performance Impact**

- **Minimal overhead**: Trait methods are lightweight
- **Efficient file operations**: Uses Laravel's optimized Storage facade
- **Background logging**: File operations don't block main operations
- **Memory efficient**: No large file operations in memory

## 🎯 **Best Practices**

1. **Always use the trait** for models with image fields
2. **Test cleanup functionality** after model changes
3. **Monitor logs** for any cleanup failures
4. **Regular storage audits** to ensure cleanliness
5. **Backup important images** before major operations

## 🔮 **Future Enhancements**

- [ ] **Soft delete support** for models with soft deletes
- [ ] **Batch cleanup** for multiple files
- [ ] **Image optimization** before storage
- [ **Cloud storage support** (S3, etc.)
- [ ] **Cleanup scheduling** for periodic maintenance

---

**Status**: ✅ **ACTIVE**  
**Last Updated**: {{ date('Y-m-d H:i:s') }}  
**Version**: 1.0.0
