# Custom Payment Offers - Permissions & Roles System

## Overview

The Custom Payment Offers system is now integrated with the Laravel permission-based access control system (RBAC - Role-Based Access Control). This allows you to:

- Grant specific users the ability to create, view, manage, and delete custom payment offers
- Control who can view payment links and payment status
- Maintain full audit trail of who created each offer

---

## Permissions

### Available Permissions

The following permissions are automatically created and available in the **Permissions** admin panel:

#### **View Custom Payment Offers**
- **Permission Key:** `custom_payment_offers.view`
- **Group:** Payments
- **Description:** View list of custom payment offers
- **Allows users to:** See the Custom Payment Offers list in the admin panel

#### **Create Custom Payment Offers**
- **Permission Key:** `custom_payment_offers.create`
- **Group:** Payments
- **Description:** Create new custom payment offers
- **Allows users to:** Click the "Create" button and add new custom payment offers

#### **Edit Custom Payment Offers**
- **Permission Key:** `custom_payment_offers.edit`
- **Group:** Payments
- **Description:** Edit existing custom payment offers
- **Status:** Currently disabled - offers cannot be edited after creation for security

#### **Delete Custom Payment Offers**
- **Permission Key:** `custom_payment_offers.delete`
- **Group:** Payments
- **Description:** Delete custom payment offers
- **Allows users to:** Delete offers with "pending" payment status (once paid/failed, cannot be deleted)

#### **View Payment Links**
- **Permission Key:** `custom_payment_offers.view_payment_link`
- **Group:** Payments
- **Description:** View and copy unique payment links for offers
- **Allows users to:** Use the "Copy Link" action to get the customer's payment URL

#### **Manage Payments**
- **Permission Key:** `custom_payment_offers.manage_payments`
- **Group:** Payments
- **Description:** View payment status and transaction details
- **Allows users to:** Click the "View" action to see offer details and payment status

---

## Roles

### Super Admin Role

The **Super Admin** role is granted **all permissions automatically**, including all Custom Payment Offer permissions.

- **Access:** Full access to all Custom Payment Offer operations
- **Cannot be restricted:** Super Admin bypasses all permission checks

### Creating Custom Roles for Custom Payment Offers

You can create custom roles (e.g., "Payment Manager", "Finance Officer") and grant them specific permissions for custom payment offers.

#### Steps to Create a Custom Role:

1. Navigate to **Admin Panel → Administration → Roles**
2. Click **Create** (top-right)
3. Fill in the role details:
   - **Role Key:** e.g., `payment_manager` (no spaces, lowercase)
   - **Display Name:** e.g., "Payment Manager"
   - **Description:** e.g., "Can create and manage custom payment offers"
   - **Active:** Toggle to enable the role
   - **Sort Order:** Set priority for navigation

4. In the **Permissions** section, select the permissions to grant:
   - Check "View Custom Payment Offers"
   - Check "Create Custom Payment Offers"
   - Check "View Payment Links"
   - Check "Manage Payments"
   - (Optional) Check "Delete Custom Payment Offers"

5. Click **Create**

6. Assign the role to users via the **Users** resource

---

## Assigning Permissions to Users

### Option 1: Direct Role Assignment (Recommended)

1. Go to **Admin Panel → Administration → Users**
2. Click on the user you want to modify
3. In the **Roles** section, add the role (e.g., "Payment Manager")
4. The user will automatically inherit all permissions from that role
5. Click **Save**

### Option 2: Direct Permission Assignment

1. Go to **Admin Panel → Administration → Users**
2. Click on the user you want to modify
3. In the **Permissions** section, select individual permissions:
   - `custom_payment_offers.view`
   - `custom_payment_offers.create`
   - `custom_payment_offers.view_payment_link`
   - `custom_payment_offers.manage_payments`
   - `custom_payment_offers.delete` (optional)
4. Click **Save**

**Note:** Role assignment is preferred over direct permissions for easier management.

---

## Access Control Matrix

### What Each User Can Do:

| Action | Super Admin | Payment Manager | Finance Officer | Regular User |
|--------|:----------:|:---------------:|:---------------:|:------------:|
| View Offers List | ✅ | ✅ (with permission) | ✅ (with permission) | ❌ |
| Create Offer | ✅ | ✅ (with permission) | ❌ | ❌ |
| View Payment Status | ✅ | ✅ (with permission) | ✅ (with permission) | ❌ |
| Copy Payment Link | ✅ | ✅ (with permission) | ❌ | ❌ |
| Delete Pending Offer | ✅ | ✅ (with permission) | ❌ | ❌ |
| Delete Paid Offer | ❌ | ❌ | ❌ | ❌ |

---

## Example Workflows

### Workflow 1: Payment Manager Creating Offers

**Scenario:** You want an employee to create custom payment offers and copy links, but not delete them.

**Steps:**
1. Create role "Payment Offer Creator" with permissions:
   - ✅ View Custom Payment Offers
   - ✅ Create Custom Payment Offers
   - ✅ View Payment Links
   - ✅ Manage Payments

2. Assign role to user
3. User can now:
   - ✅ See the "Custom Payment Offers" menu item
   - ✅ Create new offers
   - ✅ Copy payment links
   - ✅ View payment status
   - ❌ Cannot delete offers (no delete permission)

### Workflow 2: Finance Officer Viewing Only

**Scenario:** Finance team needs to view payment status but cannot create or delete.

**Steps:**
1. Create role "Finance Viewer" with permissions:
   - ✅ View Custom Payment Offers
   - ✅ Manage Payments

2. Assign role to finance team members
3. Users can now:
   - ✅ See the offers list
   - ✅ View payment details and transaction IDs
   - ❌ Cannot create, copy links, or delete

### Workflow 3: Payment Administrator

**Scenario:** Complete control over custom payment offers (like Super Admin, but not full system admin).

**Steps:**
1. Create role "Payment Administrator" with permissions:
   - ✅ View Custom Payment Offers
   - ✅ Create Custom Payment Offers
   - ✅ View Payment Links
   - ✅ Manage Payments
   - ✅ Delete Custom Payment Offers

2. Assign role to payment admins
3. Users have full control over custom payment offers

---

## Database Tables

The permissions system uses these tables:

- **`permissions`** - Stores all available permissions
- **`roles`** - Stores all available roles
- **`permission_role`** - Links permissions to roles
- **`role_user`** - Links roles to users
- **`user_permission`** - Direct user-to-permission links (optional override)

### New Permissions (Auto-created):

```sql
INSERT INTO permissions (name, display_name, group, description) VALUES
('custom_payment_offers.view', 'View Custom Payment Offers', 'Payments', 'View list of custom payment offers'),
('custom_payment_offers.create', 'Create Custom Payment Offers', 'Payments', 'Create new custom payment offers'),
('custom_payment_offers.edit', 'Edit Custom Payment Offers', 'Payments', 'Edit existing custom payment offers'),
('custom_payment_offers.delete', 'Delete Custom Payment Offers', 'Payments', 'Delete custom payment offers'),
('custom_payment_offers.view_payment_link', 'View Payment Links', 'Payments', 'View and copy unique payment links for offers'),
('custom_payment_offers.manage_payments', 'Manage Payments', 'Payments', 'View payment status and transaction details');
```

---

## Technical Details

### Permission Checking

The `CustomPaymentOfferResource` uses the following logic:

```php
// Super Admin always has access
if ($user->hasRole('super_admin')) {
    return true;
}

// Otherwise, check specific permission
return $user->hasPermission('custom_payment_offers.view');
```

### Where Permissions Are Checked

1. **Main Resource Access** (`canAccess()`) - Controls visibility of "Custom Payment Offers" menu
2. **View List** (`canViewAny()`) - Controls access to the offers list page
3. **Create** (`canCreate()`) - Controls visibility of "Create" button
4. **Delete** (`canDelete()`) - Controls visibility of "Delete" action (also checks offer status)
5. **Copy Link Action** - Requires `custom_payment_offers.view_payment_link`
6. **View Action** - Requires `custom_payment_offers.manage_payments`

---

## Troubleshooting

### User Can't See Custom Payment Offers Menu

**Solution:**
1. Check user has a role or direct permission
2. Ensure permission/role is assigned to user
3. Have user log out and log back in (session refresh)
4. Check database: `SELECT * FROM role_user WHERE user_id = X;`

### User Can't Create Offers

**Solution:**
1. Verify user has `custom_payment_offers.create` permission
2. Check if role has the permission assigned
3. Verify role is active (`is_active = 1`)
4. Test with Super Admin account to confirm functionality

### Actions Not Showing

**Solution:**
- "Copy Link" only shows for pending offers + requires `custom_payment_offers.view_payment_link`
- "View" requires `custom_payment_offers.manage_payments`
- "Delete" only shows for pending offers + requires `custom_payment_offers.delete`

---

## Seeding Permissions

To automatically seed all Custom Payment Offer permissions:

```bash
php artisan db:seed --class=CreateCustomPaymentOfferPermissionsSeeder
```

This is automatically run when you run `php artisan migrate:fresh --seed`.

---

## Security Notes

⚠️ **Important Security Considerations:**

1. **Never edit database** - Always use admin panel to modify roles and permissions
2. **Audit Trail** - Every offer tracks who created it (`created_by` field)
3. **Pending Offers Only** - Only pending offers can be deleted; paid/failed offers are permanent
4. **Edit Disabled** - Offers cannot be edited after creation to prevent fraud
5. **Role Inheritance** - Users inherit all role permissions automatically
6. **Super Admin Bypass** - Super Admin cannot be restricted; remove from super_admin role if needed

---

## Resetting to Defaults

If you need to reset all Custom Payment Offer permissions to defaults:

```bash
# Delete old permissions
php artisan tinker
>>> Permission::whereGroup('Payments')->delete();
>>> exit

# Reseed
php artisan db:seed --class=CreateCustomPaymentOfferPermissionsSeeder
```

---

## Contact & Support

For questions about the permissions system or custom payment offers functionality, contact the development team.
