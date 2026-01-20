# Custom Payment Offer System - Quick Start Guide

## Overview
This system allows admins to create custom payment offers and send direct payment links to customers. When customers click the link, they see Moyasar payment form pre-filled with the offer details.

## How It Works

### 1. Admin Creates Custom Offer
- Go to the "Custom Payment Offer" form in admin panel
- Fill in customer details:
  - **Customer Name**: Full name of the customer
  - **Email**: Customer's email address
  - **Phone**: Customer's phone number
  - **Amount**: Price in SAR (e.g., 4000)
  - **Description**: What they're paying for (e.g., "Package Tour to Dubai")
- Click **"Create Payment Link"**
- Copy the generated payment link
- Send link to customer via email, WhatsApp, or any method

### 2. Customer Clicks Link
- Customer receives the payment link
- Clicks the link (e.g., `https://yoursite.com/pay-custom-offer/abc123xyz`)
- Page shows:
  - Offer details (name, email, phone, description, amount)
  - Moyasar payment form with 3 payment methods:
    - Credit/Debit Card
    - SADAD (Saudi local payment)
    - Apple Pay
- Customer chooses payment method and enters payment details

### 3. Payment Processing
- Moyasar processes the payment securely
- On successful payment:
  - Payment status updated to "completed" in database
  - Confirmation email sent to customer
  - Success page shown to customer
- On failed payment:
  - Payment status updated to "failed"
  - Customer can retry or contact support

## Admin Panel Features

### Create New Offer
**URL**: `/admin/custom-payment-offer` (add to your admin menu)
**Component**: `CustomPaymentOfferForm.jsx`

**Form Fields:**
- Customer Name (required)
- Email (required)
- Phone (required)
- Amount (required, minimum 0.01 SAR)
- Description (required, max 1000 characters)

**Output:**
- Unique payment link ready to share
- One-click copy to clipboard

### View All Offers
**URL**: `/api/custom-payment-offers` (GET request)
**Returns:**
- List of all offers created by this admin
- Status of each offer (pending/completed/failed)
- Payment links
- Created date

**Example Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "customer_name": "Ahmed Al-Saud",
      "customer_email": "ahmed@email.com",
      "customer_phone": "+966501234567",
      "amount": 4000,
      "description": "Package Tour to Dubai",
      "payment_link": "https://yoursite.com/pay-custom-offer/abc123xyz",
      "payment_status": "pending",
      "created_at": "2026-01-19T10:30:00"
    }
  ],
  "pagination": {...}
}
```

## Database Schema

**Table**: `custom_payment_offers`

| Column | Type | Notes |
|--------|------|-------|
| id | UUID | Primary key |
| customer_name | string | Full name of customer |
| customer_email | string | Email address |
| customer_phone | string | Phone number |
| amount | decimal | Payment amount in SAR |
| description | text | What payment is for |
| unique_link | string | Unique link identifier (32 chars) |
| payment_status | string | pending/completed/failed/cancelled |
| moyasar_transaction_id | string | Transaction ID from Moyasar |
| created_by | UUID | Admin who created offer |
| created_at | timestamp | Creation date |
| updated_at | timestamp | Last update date |

## API Endpoints

### 1. Create Custom Payment Offer (Admin)
```
POST /api/custom-payment-offers
Authorization: Bearer {token}
Content-Type: application/json

{
  "customer_name": "Ahmed Al-Saud",
  "customer_email": "ahmed@email.com",
  "customer_phone": "+966501234567",
  "amount": 4000,
  "description": "Package Tour to Dubai"
}

Response:
{
  "success": true,
  "message": "Payment offer created successfully",
  "data": {
    "id": 1,
    "payment_link": "https://yoursite.com/pay-custom-offer/abc123xyz",
    "payment_status": "pending",
    ...
  }
}
```

### 2. List All Offers (Admin)
```
GET /api/custom-payment-offers
Authorization: Bearer {token}

Response:
{
  "success": true,
  "data": [{...}, {...}],
  "pagination": {...}
}
```

### 3. Get Offer Details (Public - Customer)
```
GET /api/custom-payment-offers/{uniqueLink}

Response:
{
  "success": true,
  "data": {
    "id": 1,
    "customer_name": "Ahmed Al-Saud",
    "customer_email": "ahmed@email.com",
    "customer_phone": "+966501234567",
    "amount": 4000,
    "description": "Package Tour to Dubai",
    "payment_status": "pending"
  }
}
```

### 4. Mark Payment as Successful
```
POST /api/custom-payment-offers/{uniqueLink}/payment-success
Content-Type: application/json

{
  "transaction_id": "moyasar_transaction_id"
}

Response:
{
  "success": true,
  "message": "Payment recorded successfully",
  "data": {
    "payment_status": "completed",
    "amount": 4000
  }
}
```

### 5. Mark Payment as Failed
```
POST /api/custom-payment-offers/{uniqueLink}/payment-failed

Response:
{
  "success": true,
  "message": "Payment marked as failed"
}
```

### 6. Delete Offer (Admin)
```
DELETE /api/custom-payment-offers/{id}
Authorization: Bearer {token}

Response:
{
  "success": true,
  "message": "Payment offer deleted successfully"
}
```

## Payment Link Flow

```
Admin Creates Offer
    ↓
System generates unique link
    ↓
Admin copies link and sends to customer
    ↓
Customer clicks link
    ↓
Payment page loads with offer details
    ↓
Moyasar form appears pre-filled
    ↓
Customer chooses payment method
    ↓
Customer enters payment details
    ↓
Payment gateway processes
    ↓
Success → Status updated, email sent, success page shown
or
Failure → Status updated, error page shown, customer can retry
```

## Security Features

- ✅ Unique 32-character random link (virtually impossible to guess)
- ✅ Authentication required for admin to create offers
- ✅ Admins can only see/manage their own offers
- ✅ Moyasar handles PCI compliance (card data never touches your server)
- ✅ Email confirmation sent automatically
- ✅ Payment status tracked in database for audit trail

## Frontend Implementation

### Import the admin form:
```jsx
import CustomPaymentOfferForm from '@/components/admin/CustomPaymentOfferForm';

export default function AdminPage() {
  return (
    <div>
      <CustomPaymentOfferForm />
    </div>
  );
}
```

### Customer payment page:
- Automatically created at `/pay-custom-offer/[uniqueLink]`
- No additional implementation needed
- Shows offer details + Moyasar form + success/error states

## Environment Variables Required

**Backend (.env)**:
```
MOYASAR_PUBLIC_KEY=pk_test_vcFUHJDBwiyRu4Bd3hFuPpThb6Zf2eMn8wGzxHJ
MOYASAR_SECRET_KEY=sk_test_...
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_FROM_ADDRESS=noreply@example.com
```

**Frontend (.env.local)**:
```
NEXT_PUBLIC_MOYASAR_PUBLIC_KEY=pk_test_vcFUHJDBwiyRu4Bd3hFuPpThb6Zf2eMn8wGzxHJ
```

## Troubleshooting

### "Payment offer not found"
- Link may have been deleted
- Check if unique link is correct
- Verify payment link was copied correctly

### "Failed to create offer"
- Check if user is authenticated
- Verify all required fields are filled
- Check amount is valid (minimum 0.01)

### Email not sent
- Check MAIL configuration in .env
- Verify customer email is valid
- Check application logs for errors

### Moyasar form not loading
- Verify Moyasar script loaded in HTML head
- Check NEXT_PUBLIC_MOYASAR_PUBLIC_KEY is set
- Check browser console for errors

## Tips for Best Results

1. **Clear descriptions**: Use specific descriptions so customers know what they're paying for
2. **Valid phone**: Use Saudi phone numbers with +966 prefix
3. **Round amounts**: Use whole numbers when possible (e.g., 4000 instead of 4000.50)
4. **Follow up**: Send payment link via multiple channels (email + WhatsApp) for better conversion
5. **Track status**: Check admin dashboard to see which customers have paid
6. **Re-send links**: Can create multiple links for same customer if first one expires

## File Locations

**Backend:**
- Migration: `database/migrations/2026_01_19_000001_create_custom_payment_offers_table.php`
- Model: `app/Models/CustomPaymentOffer.php`
- Controller: `app/Http/Controllers/Api/CustomPaymentOfferController.php`
- Routes: `routes/api.php` (lines with CustomPaymentOffer)

**Frontend:**
- Admin Form: `components/admin/CustomPaymentOfferForm.jsx`
- Admin Styling: `components/admin/CustomPaymentOfferForm.module.css`
- Payment Page: `app/pay-custom-offer/[uniqueLink]/page.jsx`
- Payment Styling: `app/pay-custom-offer/[uniqueLink]/page.module.css`

## Next Steps

1. ✅ Database migration completed
2. ✅ Backend API implemented
3. ✅ Frontend payment page created
4. ⏳ Add admin form to your admin dashboard menu
5. ⏳ Test with test Moyasar keys
6. ⏳ Configure email templates
7. ⏳ Deploy to production with live Moyasar keys
