# Custom Payment Offer System - COMPLETE SETUP ✅

## System Overview

You now have a **complete custom payment offer system** that allows admins to create payment links and send them to customers for direct payment through Moyasar.

### Two Admin Options Available:

1. **Laravel Admin Panel** (Built-in, Recommended) ✅
2. **React/Next.js Admin** (API-based, Alternative)

---

## Option 1: Laravel Admin Panel (RECOMMENDED)

### Access Points

| URL | Purpose |
|-----|---------|
| `/admin/custom-payment-offers` | List all offers |
| `/admin/custom-payment-offers/create` | Create new offer |
| `/admin/custom-payment-offers/{id}` | View offer with payment link |
| `/admin/custom-payment-offers/{id}/edit` | Edit offer |

### How It Works (Admin)

1. **Navigate to** `/admin/custom-payment-offers/create`
2. **Fill form:**
   - اسم العميل (Customer Name)
   - البريد الإلكتروني (Email)
   - رقم الهاتف (Phone)
   - المبلغ (Amount in SAR)
   - الوصف (Description)
3. **Click** "إنشاء عرض الدفع" (Create Payment Link)
4. **Copy link** from the show page
5. **Send to customer** via WhatsApp, Email, etc.

### Customer Experience

Customer clicks link → `/pay-custom-offer/{uniqueLink}` → Sees offer details → Clicks "Proceed to Payment" → Moyasar form loads → Chooses payment method → Pays → Success page

---

## Option 2: React/Next.js Admin (API-Based)

If you prefer a React admin dashboard, use the API directly:

### Setup React Admin Component

Create a page at `app/[lang]/admin/custom-payment-offer/page.jsx`:

```jsx
import CustomPaymentOfferForm from '@/components/admin/CustomPaymentOfferForm';

export default function CustomPaymentOfferPage() {
  return <CustomPaymentOfferForm />;
}
```

### API Endpoints Available

```
POST   /api/admin/custom-payment-offers          Create offer
GET    /api/admin/custom-payment-offers          List offers
DELETE /api/admin/custom-payment-offers/{id}     Delete offer

GET    /api/custom-payment-offers/{uniqueLink}   Get offer (public)
POST   /api/custom-payment-offers/{uniqueLink}/payment-success   Mark paid
POST   /api/custom-payment-offers/{uniqueLink}/payment-failed    Mark failed
```

---

## Complete File Structure

### Backend (Laravel)

**Models:**
```
app/Models/CustomPaymentOffer.php ✅
```

**Controllers:**
```
app/Http/Controllers/Admin/CustomPaymentOfferController.php ✅
app/Http/Controllers/Api/CustomPaymentOfferController.php ✅
```

**Views (Laravel Admin):**
```
resources/views/admin/custom-payment-offers/
├── index.blade.php      (List all offers)
├── create.blade.php     (Create form)
├── show.blade.php       (View with link)
└── edit.blade.php       (Edit form)
```

**Database:**
```
database/migrations/2026_01_19_000001_create_custom_payment_offers_table.php ✅
```

**Routes:**
```
routes/api.php      (API routes) ✅
routes/web.php      (Admin routes) ✅
```

### Frontend (Next.js)

**Components:**
```
components/admin/
├── CustomPaymentOfferForm.jsx
└── CustomPaymentOfferForm.module.css

app/pay-custom-offer/[uniqueLink]/
├── page.jsx
└── page.module.css
```

---

## Database Schema

```sql
CREATE TABLE custom_payment_offers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    unique_link VARCHAR(255) UNIQUE NOT NULL,
    payment_status VARCHAR(50) DEFAULT 'pending',
    moyasar_transaction_id VARCHAR(255) NULLABLE,
    created_by BIGINT NOT NULL (FK users),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    KEY idx_unique_link (unique_link),
    KEY idx_payment_status (payment_status)
);
```

---

## Features Implemented

### Admin Features
- ✅ Create custom payment offers (form validation)
- ✅ Auto-generate unique payment links
- ✅ List all offers with pagination
- ✅ View offer details + copy payment link
- ✅ Edit offers (before payment only)
- ✅ Delete offers (before payment only)
- ✅ Status tracking (pending/completed/failed)
- ✅ Arabic UI with Tailwind CSS

### Customer Features
- ✅ Payment page with offer details
- ✅ Pre-filled customer information
- ✅ Moyasar payment form integration
- ✅ Multiple payment methods (Card, SADAD, Apple Pay)
- ✅ Success/Error handling
- ✅ Automatic confirmation email
- ✅ Responsive design (mobile-friendly)

### Security Features
- ✅ Authentication required for admin
- ✅ Admins can only manage their own offers
- ✅ Unique links impossible to guess (32 random chars)
- ✅ Payment data stored securely in database
- ✅ PCI compliance via Moyasar
- ✅ Audit trail (created_by, timestamps)

---

## API Response Examples

### Create Offer
```bash
POST /api/admin/custom-payment-offers
Authorization: Bearer {token}
Content-Type: application/json

{
  "customer_name": "Ahmed Al-Saud",
  "customer_email": "ahmed@example.com",
  "customer_phone": "+966501234567",
  "amount": 4000,
  "description": "Tour to Dubai"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Payment offer created successfully",
  "data": {
    "id": 1,
    "customer_name": "Ahmed Al-Saud",
    "amount": 4000,
    "payment_link": "https://example.com/pay-custom-offer/abc123xyz",
    "payment_status": "pending",
    "created_at": "2026-01-19T10:30:00"
  }
}
```

### Get Offer Details
```bash
GET /api/custom-payment-offers/abc123xyz
```

**Response:**
```json
{
  "success": true,
  "data": {
    "customer_name": "Ahmed Al-Saud",
    "customer_email": "ahmed@example.com",
    "customer_phone": "+966501234567",
    "amount": 4000,
    "description": "Tour to Dubai",
    "payment_status": "pending"
  }
}
```

---

## Payment Link Flow

```
Step 1: Admin Creates Offer
├─ Fills form with customer details
├─ System generates unique 32-char link
└─ Redirects to show page

Step 2: Admin Shares Link
├─ Copies link from show page
├─ Sends via WhatsApp/Email
└─ Customer receives: https://yoursite.com/pay-custom-offer/abc123xyz

Step 3: Customer Clicks Link
├─ Payment page loads
├─ Shows offer details (name, email, phone, description, amount)
└─ Displays Moyasar payment form

Step 4: Customer Pays
├─ Selects payment method
├─ Enters payment details
├─ Moyasar processes payment
└─ Payment confirmed

Step 5: Payment Success
├─ Backend marks as "completed"
├─ Sends confirmation email
├─ Shows success page to customer
└─ Admin sees status updated to "مكتمل" (Completed)
```

---

## Testing Checklist

### Local Testing

1. **Start Laravel:**
   ```bash
   cd c:\xampp\htdocs\tilrimal-backend
   php artisan serve
   ```

2. **Start Next.js:**
   ```bash
   cd c:\xampp\htdocs\tilrimal-frontend
   npm run dev
   ```

3. **Login to Admin:**
   - Go to `http://localhost:8000/admin`
   - Login with your admin credentials

4. **Create Test Offer:**
   - Navigate to `/admin/custom-payment-offers/create`
   - Fill with test data
   - Click submit

5. **Copy Payment Link:**
   - On show page, copy the payment link
   - Example: `http://localhost:3000/pay-custom-offer/abc123xyz`

6. **Test Customer Page:**
   - Paste link in browser
   - Verify offer details display correctly

7. **Test Moyasar (Test Mode):**
   - Use test card: `4111111111111111`
   - CVC: `123`
   - Date: `12/26`

### Production Readiness

- ✅ Database migrated
- ✅ Routes registered
- ✅ Views created
- ✅ API endpoints working
- ✅ Authentication secured
- ⏳ Configure email templates
- ⏳ Set Moyasar live keys
- ⏳ Set up Moyasar webhooks
- ⏳ Test with real payments

---

## Environment Setup

### Backend (.env)

```env
MOYASAR_PUBLIC_KEY=pk_test_vcFUHJDBwiyRu4Bd3hFuPpThb6Zf2eMn8wGzxHJ
MOYASAR_SECRET_KEY=sk_test_...

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME="Tilal Al Ramal"
```

### Frontend (.env.local)

```env
NEXT_PUBLIC_MOYASAR_PUBLIC_KEY=pk_test_vcFUHJDBwiyRu4Bd3hFuPpThb6Zf2eMn8wGzxHJ
```

---

## Troubleshooting

### Laravel Admin Not Working

**"Route not found"**
```bash
php artisan route:clear
php artisan cache:clear
```

**"View not found"**
- Verify file path: `resources/views/admin/custom-payment-offers/`
- Check all 4 blade files exist
```bash
php artisan view:clear
```

**"Not authenticated"**
- Verify you're logged into admin
- Check auth middleware in routes/web.php

### Customer Payment Page Not Loading

**"Offer not found"**
- Verify unique link is copied correctly
- Check database has the offer
- Verify route matches: `/pay-custom-offer/[link]`

**"Moyasar form not showing"**
- Check NEXT_PUBLIC_MOYASAR_PUBLIC_KEY in .env.local
- Verify Moyasar SDK loaded in browser console
- Check test keys are valid

### Email Not Sending

- Configure MAIL settings in .env
- Test with: `php artisan tinker` → `Mail::raw('test', fn() => null)`
- Check Gmail 2FA & app passwords

---

## File Checklist - All Created ✅

### Backend Files
- ✅ Migration: `database/migrations/2026_01_19_000001_create_custom_payment_offers_table.php`
- ✅ Model: `app/Models/CustomPaymentOffer.php`
- ✅ API Controller: `app/Http/Controllers/Api/CustomPaymentOfferController.php`
- ✅ Admin Controller: `app/Http/Controllers/Admin/CustomPaymentOfferController.php`
- ✅ Blade View (Index): `resources/views/admin/custom-payment-offers/index.blade.php`
- ✅ Blade View (Create): `resources/views/admin/custom-payment-offers/create.blade.php`
- ✅ Blade View (Show): `resources/views/admin/custom-payment-offers/show.blade.php`
- ✅ Blade View (Edit): `resources/views/admin/custom-payment-offers/edit.blade.php`
- ✅ Routes Updated: `routes/api.php` (API routes)
- ✅ Routes Updated: `routes/web.php` (Admin routes)

### Frontend Files
- ✅ Component: `components/admin/CustomPaymentOfferForm.jsx` (React)
- ✅ Styles: `components/admin/CustomPaymentOfferForm.module.css`
- ✅ Page: `app/pay-custom-offer/[uniqueLink]/page.jsx`
- ✅ Styles: `app/pay-custom-offer/[uniqueLink]/page.module.css`

### Documentation
- ✅ `CUSTOM_PAYMENT_OFFER_GUIDE.md` (API documentation)
- ✅ `LARAVEL_ADMIN_SETUP.md` (Admin panel guide)

---

## Quick Start Commands

```bash
# Start Laravel server
cd c:\xampp\htdocs\tilrimal-backend
php artisan serve

# Start Next.js frontend
cd c:\xampp\htdocs\tilrimal-frontend
npm run dev

# Access admin panel
Open: http://localhost:8000/admin/custom-payment-offers

# Access customer payment page
Open: http://localhost:3000/pay-custom-offer/{uniqueLink}
```

---

## What's Next?

1. ✅ **System is ready to use!**
2. Test with admin panel
3. Create your first offer
4. Share payment link with test customer
5. Test payment with Moyasar test card
6. Configure email templates
7. Deploy to production
8. Switch to live Moyasar keys

---

## Support Resources

- **API Documentation**: See `CUSTOM_PAYMENT_OFFER_GUIDE.md`
- **Admin Setup Guide**: See `LARAVEL_ADMIN_SETUP.md`
- **Laravel Routes**: `php artisan route:list | grep custom-payment`
- **Moyasar Docs**: https://moyasar.com/docs
- **Database**: `mysql -u root tilrimal` → `SELECT * FROM custom_payment_offers;`

---

**System Status: ✅ COMPLETE AND READY TO USE**

Created: January 19, 2026
Last Updated: January 19, 2026
