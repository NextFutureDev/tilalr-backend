# Custom Payment Offers - Permissions Quick Reference

## 📋 Permissions Overview

```
PAYMENTS GROUP
├── ✓ View Custom Payment Offers
│   ├─ See the menu item
│   └─ Access the offers list
│
├── ✓ Create Custom Payment Offers
│   ├─ Click "Create" button
│   └─ Add new offers with customer details & amount
│
├── ✓ View Payment Links
│   ├─ Copy payment URL to send to customers
│   └─ Only visible for pending offers
│
├── ✓ Manage Payments
│   ├─ View offer details
│   ├─ See payment status (pending/paid/failed)
│   └─ View transaction IDs from Moyasar
│
├── ✓ Delete Custom Payment Offers
│   ├─ Delete pending offers
│   └─ Paid/failed offers cannot be deleted
│
└── ✓ Edit Custom Payment Offers
    └─ Currently disabled for security
```

---

## 🎯 Common Role Configurations

### Role 1: Payment Manager (Most Common)
```
Permissions:
  ✓ View Custom Payment Offers
  ✓ Create Custom Payment Offers
  ✓ View Payment Links
  ✓ Manage Payments
  ✓ Delete Custom Payment Offers

Can Do:
  ✅ Create custom payment offers
  ✅ Send payment links to customers
  ✅ Monitor payment status
  ✅ Delete pending offers if needed
  ❌ Not a system admin
```

### Role 2: Finance Officer (Viewer)
```
Permissions:
  ✓ View Custom Payment Offers
  ✓ Manage Payments

Can Do:
  ✅ See all offers and payment status
  ✅ Track transactions
  ❌ Cannot create offers
  ❌ Cannot delete offers
  ❌ Cannot copy links
```

### Role 3: Payment Viewer (Read-Only)
```
Permissions:
  ✓ View Custom Payment Offers

Can Do:
  ✅ See offers list only
  ❌ Cannot view details
  ❌ Cannot create/delete
  ❌ Cannot copy links
```

### Role 4: Super Admin (Default)
```
Permissions:
  ✓ ALL permissions automatically
  ✓ Bypasses all checks

Can Do:
  ✅ Everything
  ✅ Full system control
```

---

## 🔄 Permission Matrix: What Users Can Do

|  | Super Admin | Payment Mgr | Finance | Viewer | No Role |
|---|:---:|:---:|:---:|:---:|:---:|
| See Menu | ✅ | ✅* | ✅* | ✅* | ❌ |
| View List | ✅ | ✅ | ✅ | ✅ | ❌ |
| Create | ✅ | ✅ | ❌ | ❌ | ❌ |
| View Details | ✅ | ✅ | ✅ | ❌ | ❌ |
| Copy Link | ✅ | ✅ | ❌ | ❌ | ❌ |
| Delete | ✅ | ✅ | ❌ | ❌ | ❌ |

*Only visible if user has `custom_payment_offers.view` permission

---

## 🚀 Setup Instructions - By Role

### Create a Payment Manager Role

1. **Navigate:** Admin → Administration → Roles
2. **Click:** Create (blue button)
3. **Fill Form:**
   ```
   Role Key: payment_manager
   Display Name: Payment Manager
   Description: Manages custom payment offers
   Active: ✓ (checked)
   Sort Order: 1
   ```
4. **Select Permissions:**
   ```
   ☑ View Custom Payment Offers
   ☑ Create Custom Payment Offers
   ☑ View Payment Links
   ☑ Manage Payments
   ☑ Delete Custom Payment Offers
   ```
5. **Click:** Create
6. **Assign to Users:** Admin → Users → Select User → Add Role

---

## 🔐 Security Rules

```
🔴 CANNOT DO (By Design):
  • Regular users cannot become Super Admin
  • Paid offers cannot be deleted (permanent)
  • Offers cannot be edited after creation
  • Only users with permission can access menu

🟢 CAN DO (With Permission):
  • Create unlimited offers
  • Copy payment links
  • Delete pending offers
  • View all payment details
  • Track transaction IDs
```

---

## 📊 Database Tables

```
permissions
├── id
├── name (e.g., "custom_payment_offers.view")
├── display_name (e.g., "View Custom Payment Offers")
├── group ("Payments")
└── description

roles
├── id
├── name (e.g., "payment_manager")
├── display_name
└── permissions (many-to-many)

users
├── id
├── name
├── email
└── roles (many-to-many)
```

---

## ✅ Verification Checklist

After setting up permissions, verify:

```
□ Navigate to Admin → Permissions
  - See 6 "Payments" group permissions
  - All 6 are assigned to Super Admin role

□ Navigate to Admin → Roles
  - See any custom roles you created
  - Verify permissions are listed

□ Create a test user with "Payment Manager" role
  - Login as test user
  - Verify "Custom Payment Offers" menu appears
  - Verify "Create" button is visible
  - Verify actions (Copy, View, Delete) work

□ Create another user with limited permissions
  - Verify menu appears (if view permission)
  - Verify "Create" button is hidden (no create permission)
```

---

## 🆘 Common Issues & Fixes

### "I don't see Custom Payment Offers menu"
```
✓ Check user has Super Admin role OR custom_payment_offers.view
✓ Check role is set to Active
✓ User must logout/login to refresh
✓ Check Admin → Users → User → Roles/Permissions
```

### "Create button not showing"
```
✓ User must have custom_payment_offers.create permission
✓ Verify role has this permission assigned
✓ Clear browser cache (Ctrl+Shift+Delete)
```

### "Can't copy payment link"
```
✓ Offer must be in "pending" status
✓ User must have custom_payment_offers.view_payment_link
✓ Check role permissions
```

### "Can't view offer details"
```
✓ User must have custom_payment_offers.manage_payments
✓ Verify role assignment
✓ Offer must exist
```

---

## 📝 Setup Workflow Example

```
Your Company has 3 people:

1. Ahmad - Should create all offers
   → Create role "Offer Creator"
   → Permissions: view, create, view_payment_link, manage_payments
   → Assign to Ahmad

2. Fatima - Finance manager, views only
   → Create role "Finance Viewer"
   → Permissions: view, manage_payments
   → Assign to Fatima

3. You - Need full control
   → Already have Super Admin
   → Full access to everything

Result:
  ✅ Ahmad can create & send offers
  ✅ Fatima can track payments
  ✅ You can delete/manage if needed
  ✅ No one accidentally breaks system
  ✅ Full audit trail (who created what)
```

---

## 🎓 Learning Path

```
Step 1: Understand Permissions
  → Read this document (Quick Reference)
  → ~2 minutes

Step 2: Review Available Permissions
  → Navigate to Admin → Permissions
  → Look for "Payments" group (6 permissions)
  → ~2 minutes

Step 3: Create Your First Role
  → Follow "Setup Instructions" above
  → Create "Payment Manager" role
  → ~5 minutes

Step 4: Test the Role
  → Create test user
  → Assign role
  → Login and verify
  → ~10 minutes

Step 5: Read Full Guide (Optional)
  → See CUSTOM_PAYMENT_OFFERS_PERMISSIONS.md
  → For advanced use cases
  → ~15 minutes
```

---

## 🔗 Related Documentation

- **Setup Guide:** `CUSTOM_PAYMENT_OFFERS_PERMISSIONS_SETUP.md`
- **Full Reference:** `CUSTOM_PAYMENT_OFFERS_PERMISSIONS.md`
- **System Overview:** `CUSTOM_PAYMENT_OFFER_GUIDE.md`

---

## ⚡ TL;DR (Too Long; Didn't Read)

1. Permissions replace "Super Admin only" access
2. Create custom roles in Admin → Roles
3. Assign roles to users in Admin → Users
4. 6 permissions available in "Payments" group
5. Super Admin has all permissions by default
6. Test with a new user to verify setup

**That's it!** You now have granular control over who can manage custom payment offers.
