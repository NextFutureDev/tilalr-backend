# Custom Payment Offers - Permissions & Roles Integration ✅

## Summary

The Custom Payment Offers system is now **fully integrated with the role-based access control (RBAC) system**. You can now:

✅ **Create custom roles** for managing custom payment offers  
✅ **Grant specific permissions** instead of requiring Super Admin status  
✅ **Control who can view, create, delete, and manage** payment offers  
✅ **Granular permission control** for different team members  

---

## Quick Start

### For Super Admin (Default)

Super Admin already has **ALL Custom Payment Offer permissions**. No action needed.

Go to: **Admin Panel → Payments → Custom Payment Offers**

### For Other Users - Option 1: Create a Role (Recommended)

**Step 1:** Create a new role
1. Go to **Admin Panel → Administration → Roles**
2. Click **Create**
3. Fill in:
   - **Role Key:** `payment_manager`
   - **Display Name:** Payment Manager
   - **Description:** Can create and manage custom payment offers

**Step 2:** Add Permissions to Role
Check these permissions:
- ✅ View Custom Payment Offers
- ✅ Create Custom Payment Offers
- ✅ View Payment Links
- ✅ Manage Payments
- ✅ Delete Custom Payment Offers (optional)

**Step 3:** Assign Role to User
1. Go to **Admin Panel → Administration → Users**
2. Select the user
3. Add the **Payment Manager** role
4. Click **Save**

User now has access! They can:
- ✅ Create custom payment offers
- ✅ Copy payment links to send to customers
- ✅ View payment status and transaction details
- ✅ Delete pending offers
- ❌ Cannot view/manage other system features

### For Other Users - Option 2: Direct Permission Assignment

1. Go to **Admin Panel → Administration → Users**
2. Select the user
3. In **Permissions** section, check:
   - ✅ View Custom Payment Offers
   - ✅ Create Custom Payment Offers
   - ✅ View Payment Links (if they need to copy links)
   - ✅ Manage Payments (if they need to view status)
   - ✅ Delete Custom Payment Offers (if they need to delete)
4. Click **Save**

---

## Available Permissions

| Permission | Group | Description |
|------------|-------|-------------|
| `custom_payment_offers.view` | Payments | View list of custom payment offers |
| `custom_payment_offers.create` | Payments | Create new custom payment offers |
| `custom_payment_offers.edit` | Payments | Edit existing custom payment offers (disabled by default) |
| `custom_payment_offers.delete` | Payments | Delete pending custom payment offers |
| `custom_payment_offers.view_payment_link` | Payments | View and copy unique payment links |
| `custom_payment_offers.manage_payments` | Payments | View payment status and transaction details |

---

## Example: Create a Finance Officer Role

**Scenario:** Finance team should view payment status but NOT create or delete offers.

1. Go to **Roles** → Click **Create**
2. Enter:
   - **Role Key:** `finance_officer`
   - **Display Name:** Finance Officer
   - **Description:** Can view custom payment offers and payment status

3. In Permissions, check ONLY:
   - ✅ View Custom Payment Offers
   - ✅ Manage Payments

4. Click **Create**

5. Assign to finance team members

**Result:** They can see the offers list and view payment details, but:
- ❌ Cannot create new offers
- ❌ Cannot copy payment links
- ❌ Cannot delete offers

---

## Files Modified

### Backend
1. **`CustomPaymentOfferResource.php`** - Updated with permission checks:
   - `canAccess()` - Checks view permission
   - `canViewAny()` - Checks view permission
   - `canCreate()` - Checks create permission
   - `canDelete()` - Checks delete permission
   - Action visibility - Checks specific permissions for copy link, view, delete

2. **`CreateCustomPaymentOfferPermissionsSeeder.php`** - NEW
   - Creates all 6 Custom Payment Offer permissions
   - Auto-assigns to Super Admin role
   - Run via: `php artisan db:seed --class=CreateCustomPaymentOfferPermissionsSeeder`

3. **`DatabaseSeeder.php`** - Updated
   - Added call to `CreateCustomPaymentOfferPermissionsSeeder`

### Documentation
- **`CUSTOM_PAYMENT_OFFERS_PERMISSIONS.md`** - Complete guide with examples and troubleshooting

---

## How It Works

### Permission Checks in the Resource

```php
// When user tries to access Custom Payment Offers menu/list:
if ($user->hasRole('super_admin')) {
    // ✅ Super Admin always has access
} else if ($user->hasPermission('custom_payment_offers.view')) {
    // ✅ User has specific permission
} else {
    // ❌ User cannot access
}
```

### Action Visibility

- **"Copy Link" button** - Shows only if user has `custom_payment_offers.view_payment_link` AND offer is pending
- **"View" button** - Shows only if user has `custom_payment_offers.manage_payments`
- **"Delete" button** - Shows only if user has `custom_payment_offers.delete` AND offer is pending
- **"Create" button** - Shows only if user has `custom_payment_offers.create`

---

## Testing

### Test 1: Verify Permissions Created
```bash
php verify_custom_offer_permissions.php
```

Should show:
- ✓ All 6 custom payment offer permissions
- ✓ Permissions assigned to Super Admin role

### Test 2: Create Test Role and User
1. Create role "Payment Manager" with all permissions
2. Create test user
3. Assign role to test user
4. Login as test user
5. Verify can see Custom Payment Offers menu and create offers

### Test 3: Limited Permissions
1. Create role "Viewer Only" with just `custom_payment_offers.view`
2. Assign to test user
3. Login as test user
4. Verify:
   - ✅ Can see offers list
   - ❌ Cannot see "Create" button
   - ❌ Cannot see "Copy Link" button
   - ❌ Cannot see "View" button

---

## Database Tables Used

- `permissions` - 6 new rows for custom payment offers
- `roles` - No new rows (use existing or create custom)
- `permission_role` - Links roles to permissions
- `role_user` - Links users to roles

---

## Troubleshooting

### Issue: User can't see Custom Payment Offers menu

**Solution:**
1. Check user has Super Admin role OR `custom_payment_offers.view` permission
2. Ensure permission is assigned to user's role
3. User logout and login (refresh session)
4. Check: Admin → Administration → Users → Select User → Roles/Permissions

### Issue: User can see menu but can't click "Create"

**Solution:**
1. Check user has `custom_payment_offers.create` permission
2. Ensure role is set to Active
3. Clear browser cache and refresh

### Issue: Actions (Copy Link, View, Delete) not showing

**Solution:**
- "Copy Link" requires `custom_payment_offers.view_payment_link` + pending offer
- "View" requires `custom_payment_offers.manage_payments`
- "Delete" requires `custom_payment_offers.delete` + pending offer

Check user has the required permissions.

---

## Security Notes

⚠️ **Important:**

1. **Super Admin cannot be restricted** - They will always have all permissions
2. **Pending offers only can be deleted** - Paid/failed offers are permanent (audit trail)
3. **Offers cannot be edited** - Only viewable and can be deleted if pending (fraud prevention)
4. **Always use Admin Panel** - Don't modify roles/permissions directly in database
5. **Audit trail** - Every offer has `created_by` field tracking who created it

---

## What Changed

### Before
- Only Super Admin could create/manage custom payment offers
- No way to grant other users access without making them Super Admin

### After ✅
- Any user with `custom_payment_offers.create` permission can create offers
- Fine-grained control: view, create, delete, manage payments
- Create custom roles like "Payment Manager" or "Finance Officer"
- Maintain security with audit trails
- Better team collaboration without creating unnecessary Super Admins

---

## Next Steps

1. ✅ Review the permissions in Admin Panel → Administration → Permissions
2. ✅ Create custom roles for your team
3. ✅ Assign roles to team members
4. ✅ Test access with different user accounts
5. ✅ Read full guide: `CUSTOM_PAYMENT_OFFERS_PERMISSIONS.md`

---

## Support

For detailed documentation, see: **`CUSTOM_PAYMENT_OFFERS_PERMISSIONS.md`**

For issues or questions, contact the development team.
