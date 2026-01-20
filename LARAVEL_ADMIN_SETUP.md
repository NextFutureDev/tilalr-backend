# Laravel Admin Custom Payment Offer System - Setup Guide

## Files Created

### Backend (Laravel)

**Controller:**
- `app/Http/Controllers/Admin/CustomPaymentOfferController.php` - Admin panel controller with 7 methods

**Views (Blade Templates):**
- `resources/views/admin/custom-payment-offers/index.blade.php` - List all offers
- `resources/views/admin/custom-payment-offers/create.blade.php` - Create form
- `resources/views/admin/custom-payment-offers/show.blade.php` - View offer with payment link
- `resources/views/admin/custom-payment-offers/edit.blade.php` - Edit form

**Routes:**
- Added to `routes/web.php` with auth middleware

## How to Access

### Admin Panel URLs

**List All Offers:**
```
GET /admin/custom-payment-offers
```

**Create New Offer:**
```
GET /admin/custom-payment-offers/create
POST /admin/custom-payment-offers
```

**View/Show Offer (with payment link):**
```
GET /admin/custom-payment-offers/{id}
```

**Edit Offer:**
```
GET /admin/custom-payment-offers/{id}/edit
PUT /admin/custom-payment-offers/{id}
```

**Delete Offer:**
```
DELETE /admin/custom-payment-offers/{id}
```

## Features

### List View (`/admin/custom-payment-offers`)
- ✅ Table with all your offers
- ✅ Shows: Name, Email, Amount, Status, Date
- ✅ Statistics cards (Total, Pending, Completed, Failed)
- ✅ Edit, View, Delete buttons
- ✅ Pagination (20 per page)
- ✅ Arabic UI

### Create Form (`/admin/custom-payment-offers/create`)
- ✅ Input fields for customer details
- ✅ Form validation with error messages
- ✅ Auto-generates unique payment link
- ✅ Arabic labels and placeholders

### Show/View Page (`/admin/custom-payment-offers/{id}`)
- ✅ Display all offer details
- ✅ Shows payment link
- ✅ One-click copy to clipboard button
- ✅ Shows payment transaction ID if completed
- ✅ Edit/Delete buttons if pending

### Edit Form (`/admin/custom-payment-offers/{id}/edit`)
- ✅ Edit all customer details
- ✅ Only available while payment is pending
- ✅ Form validation

## Database Structure

**Table:** `custom_payment_offers`

| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Auto increment |
| customer_name | string | Customer full name |
| customer_email | string | Email address |
| customer_phone | string | Phone number |
| amount | decimal(10,2) | Amount in SAR |
| description | text | What payment is for |
| unique_link | string | 32-char unique identifier |
| payment_status | string | pending/completed/failed |
| moyasar_transaction_id | string | Transaction ID from Moyasar |
| created_by | bigint | Admin who created it |
| created_at | timestamp | Creation date |
| updated_at | timestamp | Last update |

## Step-by-Step: Admin Usage

### 1. Go to Create Page
Navigate to `/admin/custom-payment-offers/create`

### 2. Fill Form
- Name: Customer full name
- Email: customer@example.com
- Phone: +966501234567
- Amount: 4000
- Description: "Tour to Dubai" or "Training Course"

### 3. Click "Create Payment Link"
System generates unique link automatically

### 4. View Link
Redirects to show page where you can:
- See all offer details
- Copy payment link to clipboard
- Share link with customer (email, WhatsApp, etc.)

### 5. Customer Pays
Customer clicks link → sees payment page → pays via Moyasar

### 6. Track Payment
Go back to list `/admin/custom-payment-offers` to see status:
- **Pending** (yellow) - Waiting for customer to pay
- **Completed** (green) - Payment successful
- **Failed** (red) - Payment failed

## Integration with Existing Admin

If you have an existing admin dashboard navigation, add this link:

```blade
<a href="{{ route('admin.custom-payment-offers.index') }}">
    عروض الدفع المخصصة
</a>
```

Or in English:
```blade
<a href="{{ route('admin.custom-payment-offers.index') }}">
    Custom Payment Offers
</a>
```

## Security Features

✅ Authentication required (`->middleware('auth')`)
✅ Users can only see/edit their own offers (`created_by` check)
✅ Editing disabled after payment is completed
✅ Unique links cannot be guessed (32 random characters)
✅ Payment status immutable once completed

## Payment Flow

```
Admin Creates Offer
    ↓
System generates unique link
    ↓
Admin copies link from show page
    ↓
Admin shares link via WhatsApp/Email
    ↓
Customer clicks link
    ↓
Payment page loads (frontend)
    ↓
Customer sees offer details + Moyasar form
    ↓
Customer pays
    ↓
Backend marks as completed + sends email
    ↓
Success page shown to customer
```

## Error Handling

- ✅ Validation errors show on forms
- ✅ Only admins can access admin routes
- ✅ Users can only edit their own offers
- ✅ Completed payments cannot be edited
- ✅ All database operations use transactions

## Testing Locally

1. **Start Laravel:**
   ```bash
   php artisan serve
   ```

2. **Run Migration (if not done):**
   ```bash
   php artisan migrate
   ```

3. **Login as Admin:**
   - Go to `/admin` and login

4. **Create Test Offer:**
   - Go to `/admin/custom-payment-offers/create`
   - Fill form with test data
   - Click submit

5. **Copy Payment Link:**
   - On show page, copy the payment link
   - Share with test customer

6. **Test Payment:**
   - Use Moyasar test card: `4111111111111111`
   - CVC: Any 3 digits
   - Date: Any future date

## Deployment Checklist

- ✅ Database migrated (`php artisan migrate`)
- ✅ Admin routes loaded
- ✅ Authentication middleware active
- ✅ Blade templates in correct folder
- ✅ CSS via Tailwind (CDN included in views)
- ✅ Routes named correctly (used in views)
- ✅ Moyasar test keys in frontend .env

## Troubleshooting

### "Route not found"
- Check web.php routes are added
- Verify middleware syntax
- Clear route cache: `php artisan route:clear`

### "Views not found"
- Check folder structure: `resources/views/admin/custom-payment-offers/`
- Ensure all 4 blade files are in place
- Clear view cache: `php artisan view:clear`

### "Not authorized"
- Check auth middleware is applied
- Verify user is logged in
- Check created_by matches auth()->id()

### "Link doesn't work"
- Verify link is exactly copied
- Check unique_link value in database
- Ensure frontend route is `/pay-custom-offer/[link]`

## File Checklist

**Backend Files Created:**
- ✅ `app/Http/Controllers/Admin/CustomPaymentOfferController.php`
- ✅ `resources/views/admin/custom-payment-offers/index.blade.php`
- ✅ `resources/views/admin/custom-payment-offers/create.blade.php`
- ✅ `resources/views/admin/custom-payment-offers/show.blade.php`
- ✅ `resources/views/admin/custom-payment-offers/edit.blade.php`
- ✅ `routes/web.php` (modified - added custom payment routes)

**Database Files:**
- ✅ `database/migrations/2026_01_19_000001_create_custom_payment_offers_table.php` (already migrated)

**API Files (from previous step):**
- ✅ `app/Models/CustomPaymentOffer.php`
- ✅ `app/Http/Controllers/Api/CustomPaymentOfferController.php`
- ✅ `routes/api.php` (modified - added API routes)

**Frontend Files:**
- ✅ `components/admin/CustomPaymentOfferForm.jsx` (React - for API)
- ✅ `components/admin/CustomPaymentOfferForm.module.css`
- ✅ `app/pay-custom-offer/[uniqueLink]/page.jsx`
- ✅ `app/pay-custom-offer/[uniqueLink]/page.module.css`

## Next Steps

1. ✅ Database migration done
2. ✅ Laravel admin panel complete
3. ✅ API endpoints available
4. ⏳ Test admin panel by creating offers
5. ⏳ Test customer payment flow
6. ⏳ Configure email templates for confirmations
7. ⏳ Set up Moyasar webhooks for production

## Support

All routes follow Laravel resource conventions:
- `index` - List
- `create` - Show create form
- `store` - Save new
- `show` - View single
- `edit` - Show edit form
- `update` - Save changes
- `destroy` - Delete

Use `route('admin.custom-payment-offers.index')` to generate URLs in your code.
