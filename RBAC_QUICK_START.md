# RBAC Quick Reference Guide

## 🎯 What Was Built

A complete **Role-Based Access Control (RBAC)** system with:
- ✅ 3 roles (Executive Manager, Consultant, Administration)
- ✅ 38 granular permissions
- ✅ 50+ lines of API middleware
- ✅ 2 frontend guard components
- ✅ 1 comprehensive useRole hook
- ✅ Database schema and migrations
- ✅ Enhanced authentication endpoints

---

## 🚀 Quick Start

### For Backend Developers

#### 1. Protect API Routes
Add middleware to `routes/api.php`:
```php
// Only executives can access
Route::middleware('auth:sanctum', 'check.role:executive_manager')->group(function () {
    Route::resource('international-destinations', InternationalDestinationController::class);
});

// Executives and consultants
Route::middleware('auth:sanctum', 'check.role:executive_manager,consultant')->group(function () {
    Route::resource('island-destinations', IslandDestinationController::class);
});

// Specific permission check
Route::middleware('auth:sanctum', 'check.permission:delete_bookings')->post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);
```

#### 2. Test with cURL
```bash
# Login as consultant
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"consultant@example.com","password":"password"}'

# Response includes roles and permissions:
# {
#   "user": {...},
#   "roles": ["consultant"],
#   "permissions": ["view_island_destinations", "create_offers", ...],
#   "token": "..."
# }

# Try accessing executive endpoint with consultant token
curl -X GET http://localhost:8000/api/international-destinations \
  -H "Authorization: Bearer YOUR_TOKEN"

# Should get 403 Forbidden response
```

### For Frontend Developers

#### 1. Protect Pages
```jsx
// pages/admin/island-destinations.jsx
import { ProtectedRoute } from '@/components/guards/ProtectedRoute';
import AdminPanel from '@/components/admin/IslandDestinationsAdmin';

export default function Page() {
  return (
    <ProtectedRoute permissions={['view_island_destinations']}>
      <AdminPanel />
    </ProtectedRoute>
  );
}
```

#### 2. Conditional UI
```jsx
import { PermissionCheck } from '@/components/guards/PermissionCheck';
import { useRole } from '@/lib/useRole';

export function AdminNav() {
  const { isExecutiveManager, isConsultant } = useRole();

  return (
    <nav>
      {isExecutiveManager && (
        <>
          <a href="/admin/international-destinations">International</a>
          <a href="/admin/international-flights">Flights</a>
          <a href="/admin/international-hotels">Hotels</a>
        </>
      )}

      {(isExecutiveManager || isConsultant) && (
        <>
          <a href="/admin/island-destinations">Islands</a>
          <a href="/admin/offers">Offers</a>
        </>
      )}

      <PermissionCheck permissions={['manage_contacts']}>
        <a href="/admin/contacts">Communications</a>
      </PermissionCheck>
    </nav>
  );
}
```

#### 3. Programmatic Checks
```jsx
import { useRole } from '@/lib/useRole';

export function DeleteButton({ id }) {
  const { can } = useRole();

  if (!can('delete_island_destinations')) {
    return <span className="text-muted">Delete (Locked)</span>;
  }

  return <button onClick={() => deleteDestination(id)}>Delete</button>;
}
```

---

## 📊 Role Permissions Matrix

| Resource | Executive | Consultant | Admin |
|----------|:---------:|:----------:|:-----:|
| **International Destinations** | ✓✓✓✓ | ✗ | ✗ |
| **International Flights** | ✓✓✓✓ | ✗ | ✗ |
| **International Hotels** | ✓✓✓✓ | ✗ | ✗ |
| **International Packages** | ✓✓✓✓ | ✗ | ✗ |
| **Island Destinations** | ✓✓✓✓ | ✓✓✓✓ | ✗ |
| **Offers** | ✗ | ✓✓✓✓ | ✗ |
| **Services** | ✗ | ✓✓✓✓ | ✗ |
| **Trips** | ✗ | ✓✓✓✓ | ✗ |
| **Contacts** | ✓✓ | ✓✓ | ✓✓ |
| **Reservations** | ✓✓ | ✓✓ | ✗ |
| **Bookings** | ✓✓ | ✓✓ | ✗ |

Legend: ✓✓ = view/manage, ✓✓✓✓ = create/read/update/delete

---

## 🛠 Core Files

### Backend Files
- `app/Http/Middleware/CheckPermission.php` - Permission enforcement
- `app/Http/Middleware/CheckRole.php` - Role enforcement
- `app/Models/User.php` - Role relationships and permission methods
- `app/Models/Role.php` - Role model with permission relationships
- `app/Models/Permission.php` - Permission model
- `app/Http/Controllers/Api/AuthController.php` - Updated login/user endpoints
- `database/seeders/RolePermissionSeeder.php` - 3 roles + 38 permissions
- `database/migrations/2026_01_05_114500_add_rbac_columns.php` - RBAC schema
- `database/migrations/2026_01_05_114600_add_description_to_roles.php` - Description column

### Frontend Files
- `lib/useRole.js` - Hook for permission checking
- `components/guards/ProtectedRoute.jsx` - Page-level protection
- `components/guards/PermissionCheck.jsx` - UI-level conditional rendering
- `providers/AuthProvider.js` - Updated with roles/permissions

---

## 🔍 Database Schema

### roles table
```
id, name, title_en, title_ar, display_name, description, created_at, updated_at
```

### permissions table
```
id, name, display_name, description, created_at, updated_at
```

### role_user pivot table
```
id, user_id, role_id, created_at, updated_at
```

### permission_role pivot table
```
id, permission_id, role_id, created_at, updated_at
```

---

## 📝 Assigning Roles to Users

### Via Code
```php
$user = User::find(1);
$user->roles()->sync(['executive_manager']); // Replace roles
$user->roles()->attach('consultant'); // Add role
$user->roles()->detach('consultant'); // Remove role
```

### Via Database
```sql
INSERT INTO role_user (user_id, role_id) VALUES (1, 1); -- Assign executive_manager to user 1
```

### Via Filament Admin (TODO)
- Create RoleResource in Filament
- Update UserResource to include role assignment form
- Manage permissions from admin panel

---

## 🧪 Testing Checklist

- [ ] Login as executive_manager - can view all resources
- [ ] Login as consultant - can't view international resources
- [ ] Login as administration - can only see contacts
- [ ] Try accessing unauthorized page - redirected to /unauthorized
- [ ] Try API call without token - get 401 Unauthorized
- [ ] Try API call without permission - get 403 Forbidden
- [ ] Edit button visible only with edit permission
- [ ] Menu items visible only for authorized roles
- [ ] Roles and permissions in auth response match database

---

## 🚨 Important Notes

1. **Frontend is for UX only** - Always check permissions on backend
2. **Middleware enforces access** - API returns 403 if permission missing
3. **Roles cascade** - User can have multiple roles, permissions unite
4. **Database-driven** - No hardcoded permissions, all in database
5. **Token-based** - Works with Sanctum token authentication
6. **Scalable** - Easy to add new roles/permissions in seeder

---

## 📚 Full Documentation

See `RBAC_IMPLEMENTATION.md` for:
- Complete API route examples
- Advanced component usage
- All 38 permissions listed
- Security considerations
- Next steps for integration

---

**Status**: ✅ Ready for Integration
