# 🎯 Payment & OTP Systems - Integration Guide

**Version**: 1.0  
**Last Updated**: January 18, 2026  
**Purpose**: Complete guide to payment systems and SMS OTP integration points

---

## 📍 Quick Navigation

| System | Location | Config File | Env Variables |
|--------|----------|-------------|----------------|
| **OTP** | `app/Services/OtpService.php` | `config/otp.php` | `OTP_MODE`, `OTP_FIXED_CODE` |
| **SMS** | `app/Services/SmsService.php` | `.env` | `TWILIO_SID`, `TWILIO_TOKEN`, etc. |
| **Payment** | `app/Http/Controllers/Api/PaymentController.php` | `config/services.php` | `MOYASAR_*`, `TELR_*` |

---

## 🔐 OTP System (SMS Authentication)

### Current State
- **Mode**: FIXED (Development)
- **Default Code**: `1234`
- **System**: Uses fixed code for testing, ready for real SMS integration
- **Storage**: Database table `otp_codes`

### Where to Change OTP Method

#### Step 1: Check Current Configuration
File: [config/otp.php](../config/otp.php)

```php
return [
    'mode' => env('OTP_MODE', 'fixed'),      // ⚙️ CHANGE THIS for different modes
    'fixed_code' => env('OTP_FIXED_CODE', '1234'),  // ⚙️ Development code
    'expiry_minutes' => env('OTP_EXPIRY', 5),
    'resend_cooldown' => env('OTP_RESEND_COOLDOWN', 60),
    'max_attempts' => env('OTP_MAX_ATTEMPTS', 3),
];
```

#### Step 2: Supported OTP Modes

| Mode | Purpose | Configuration |
|------|---------|----------------|
| **fixed** | Development/Testing | Always returns `1234` or custom code |
| **random** | Random codes (logged) | Generates 6-digit codes, logs them |
| **sms** | Production SMS | Sends to real SMS provider |

#### Step 3: How to Switch Modes

**Option A: Use Fixed Code (CURRENT - for development)**
```env
# .env file
OTP_MODE=fixed
OTP_FIXED_CODE=1234
```
✅ Uses same code always, visible in API response as `dev_otp`

**Option B: Use Random Codes (Logged)**
```env
# .env file
OTP_MODE=random
OTP_EXPIRY=5
```
✅ Generates random 6-digit code, logged in Laravel logs (`storage/logs/`)

**Option C: Use Real SMS (Production)**
```env
# .env file
OTP_MODE=sms
```
⚠️ Requires SMS provider configuration (see Step 4)

---

### Step 4: Integrate Saudi SMS Provider

#### Current SMS Service
File: [app/Services/SmsService.php](../app/Services/SmsService.php)

```php
public function send(string $phone, string $message): bool
{
    // Currently supports Twilio
    $sid = env('TWILIO_SID');
    $token = env('TWILIO_TOKEN');
    $from = env('TWILIO_FROM');
    
    if ($sid && $token && $from) {
        // Sends via Twilio
        $client = new \Twilio\Rest\Client($sid, $token);
        $client->messages->create($phone, [
            'from' => $from,
            'body' => $message,
        ]);
    }
    // Fallback: logs to storage/logs/
}
```

#### To Add Saudi OTP Provider (Recommended Providers):

**Option 1: Unifonic (Saudi Arabia)**
- Website: https://www.unifonic.com
- SDK: Available via Composer
- Supports: SMS, OTP services

**Option 2: Zain SMS Gateway**
- Zain Saudi Arabia SMS API
- Custom integration

**Option 3: Keep Twilio (International)**
- Already configured
- Works everywhere but higher cost

#### Integration Steps for Saudi SMS Provider

1. **Install Provider Package**
```bash
composer require unifonic/sms  # Example for Unifonic
```

2. **Update .env**
```env
# Option A: Keep Twilio
TWILIO_SID=your_twilio_sid
TWILIO_TOKEN=your_twilio_token
TWILIO_FROM=+1234567890

# Option B: Use Unifonic (Saudi)
UNIFONIC_API_KEY=your_unifonic_key
UNIFONIC_SENDER_ID=your_sender_name

# Option C: Use Zain
ZAIN_API_KEY=your_zain_key
ZAIN_SENDER=your_sender_id
```

3. **Update SmsService.php**

Add method to detect provider and route SMS:
```php
public function send(string $phone, string $message): bool
{
    $provider = env('SMS_PROVIDER', 'twilio'); // ⚙️ ADD THIS ENV VAR
    
    if ($provider === 'unifonic') {
        return $this->sendViaUnifonic($phone, $message);
    } elseif ($provider === 'zain') {
        return $this->sendViaZain($phone, $message);
    } else {
        return $this->sendViaTwilio($phone, $message);
    }
}

private function sendViaUnifonic($phone, $message): bool
{
    try {
        $client = new \Unifonic\Client(env('UNIFONIC_API_KEY'));
        $client->send($phone, $message, [
            'senderID' => env('UNIFONIC_SENDER_ID'),
        ]);
        return true;
    } catch (\Exception $e) {
        Log::warning("Unifonic SMS failed: " . $e->getMessage());
        return false;
    }
}
```

4. **Update .env to use Saudi provider**
```env
OTP_MODE=sms                    # Enable SMS mode
SMS_PROVIDER=unifonic           # ⚙️ CHANGE THIS to your provider
UNIFONIC_API_KEY=your_key_here
UNIFONIC_SENDER_ID=TILRIMAL
```

5. **Test SMS**
```bash
# Via API
curl -X POST http://localhost:8000/api/auth/send-otp \
  -H "Content-Type: application/json" \
  -d '{"phone": "+966501234567", "type": "register"}'

# Should return: { "success": true, "message": "OTP sent successfully" }
# Check logs: tail -f storage/logs/laravel.log
```

---

### File Locations for OTP System

| File | Purpose | Modification Notes |
|------|---------|-------------------|
| [app/Services/OtpService.php](../app/Services/OtpService.php) | Core OTP logic | Modify `send()` method for custom SMS |
| [app/Services/SmsService.php](../app/Services/SmsService.php) | **PRIMARY** - Change SMS provider here | Add provider routing logic |
| [app/Http/Controllers/Api/OtpController.php](../app/Http/Controllers/Api/OtpController.php) | API endpoints | No changes needed |
| [config/otp.php](../config/otp.php) | OTP configuration | Change `OTP_MODE` env var |
| [app/Models/OtpCode.php](../app/Models/OtpCode.php) | OTP database model | No changes needed |

---

## 💳 Payment System (Moyasar/Payment Gateways)

### Current State
- **Gateway**: Moyasar (Saudi Payment Gateway)
- **Methods**: Credit Card, STC Pay
- **Currency**: SAR (Saudi Riyals)
- **Amount**: Stored in halalas (1 SAR = 100 halalas) internally

### Where to Change Payment Method

#### Step 1: Check Current Configuration
File: [config/services.php](../config/services.php)

```php
'moyasar' => [
    'publishable_key' => env('MOYASAR_API_KEY', 'pk_live_...'),
    'secret_key' => env('MOYASAR_SECRET_KEY', 'sk_live_...'),
    'test_mode' => env('MOYASAR_TEST_MODE', false),
],

'payment_gateway' => env('PAYMENT_GATEWAY', 'moyasar'), // ⚙️ CHANGE THIS
```

#### Step 2: Supported Payment Gateways

| Gateway | Country | Status | Currencies |
|---------|---------|--------|-----------|
| **Moyasar** | Saudi Arabia | ✅ Active | SAR, AED, KWD, BHD |
| **Telr** | Saudi Arabia | 🔄 Configured | SAR |
| **Stripe** | USA (International) | 📦 Available | USD, EUR, etc. |
| **2Checkout** | International | 📦 Available | Multiple |

#### Step 3: How to Switch Payment Gateway

**Option A: Moyasar (CURRENT)**
```env
# .env file
PAYMENT_GATEWAY=moyasar
MOYASAR_API_KEY=pk_live_JjGYt4f9iWDGpc9uCE9FCMBvZ9u5FBa5SsQvEFAY
MOYASAR_SECRET_KEY=sk_live_CqsRUfH7SJ5H2dnJvdk654F4LvZb9FZs7ipNwyZJ
MOYASAR_TEST_MODE=false
```

**Option B: Telr (Saudi Alternative)**
```env
# .env file
PAYMENT_GATEWAY=telr
TELR_STORE_ID=25484
TELR_AUTH_KEY=tF@zx^Gq5W
TELR_TEST_MODE=true
```

**Option C: Stripe (International)**
```env
# .env file
PAYMENT_GATEWAY=stripe
STRIPE_SECRET_KEY=sk_live_...
STRIPE_PUBLISHABLE_KEY=pk_live_...
```

---

### Step 4: Payment Flow Architecture

#### Current Payment Flow
```
1. User clicks "Pay Now" on booking
   ↓
2. Frontend calls POST /api/payments/initiate
   ├─ Sends: booking_id, amount
   ├─ Returns: Moyasar config + payment form details
   ↓
3. Frontend shows Moyasar payment form
   ├─ User enters card details
   ├─ Moyasar processes payment
   ↓
4. Payment callback received at POST /api/payments/callback
   ├─ Verifies payment with Moyasar API
   ├─ Updates booking.payment_status
   ├─ Updates booking.status
   ↓
5. User redirected to /booking/{id}?payment=paid
```

#### Key Payment Controller Methods

File: [app/Http/Controllers/Api/PaymentController.php](../app/Http/Controllers/Api/PaymentController.php)

| Method | Purpose | Change Point |
|--------|---------|--------------|
| `initiate()` | Start payment process | Line 115 - Add gateway logic here |
| `callback()` | Handle payment callback | Line 183 - Webhook verification |
| `verifyPayment()` | Verify with payment API | Line 308 - API integration |
| `telrWebhook()` | Telr webhook handler | Line 291 - Uncomment for Telr |
| `moyasarWebhook()` | Moyasar webhook handler | Line 296 - Already configured |

---

### Step 5: How to Switch Payment Gateways (Code Changes)

#### Location: [app/Http/Controllers/Api/PaymentController.php](../app/Http/Controllers/Api/PaymentController.php) Line 115

**Current Code (Moyasar)**:
```php
public function initiate(Request $request)
{
    // ... validation code ...
    
    $gateway = env('PAYMENT_GATEWAY', 'moyasar');
    
    if ($gateway === 'moyasar') {
        return $this->initiateMoyasar($request, $booking, $amountInSar, $amountInHalalas);
    } elseif ($gateway === 'telr') {
        return $this->initiateTelr($request, $booking, $amountInSar);
    } elseif ($gateway === 'stripe') {
        return $this->initiateStripe($request, $booking, $amountInSar);
    }
}

private function initiateMoyasar($request, $booking, $amountInSar, $amountInHalalas)
{
    // Current Moyasar implementation - lines 143-158
    $moyasarConfig = [
        'publishable_api_key' => env('MOYASAR_PUBLISHABLE_KEY'),
        'amount' => $amountInHalalas,
        'currency' => 'SAR',
        'description' => 'دفع حجز - ' . ($booking->trip_slug ?? 'حجز'),
        'methods' => ['creditcard', 'stcpay'],
        'metadata' => [
            'booking_id' => $booking->id,
            'amount_sar' => $amountInSar,
        ],
        'language' => 'ar',
        'callback_url' => config('app.frontend_url') . '/payment-callback',
    ];

    return response()->json([
        'success' => true,
        'moyasar_config' => $moyasarConfig,
        'amount' => $amountInSar,
    ]);
}
```

#### To Add Telr Gateway:
```php
private function initiateTelr($request, $booking, $amountInSar)
{
    $telrConfig = [
        'store_id' => env('TELR_STORE_ID'),
        'auth_key' => env('TELR_AUTH_KEY'),
        'amount' => $amountInSar * 100, // Telr uses cents
        'currency' => '682', // SAR currency code
        'order_ref' => 'BOOKING-' . $booking->id,
        'description' => 'دفع حجز - ' . ($booking->trip_slug ?? 'حجز'),
        'return_url' => config('app.frontend_url') . '/payment-callback',
        'notif_url' => config('app.url') . '/api/payments/webhook/telr',
    ];

    return response()->json([
        'success' => true,
        'telr_config' => $telrConfig,
        'gateway' => 'telr',
        'amount' => $amountInSar,
    ]);
}
```

#### To Add Stripe:
```php
private function initiateStripe($request, $booking, $amountInSar)
{
    \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'sar',
                'product_data' => [
                    'name' => 'Booking Payment - ' . $booking->trip_slug,
                ],
                'unit_amount' => (int)($amountInSar * 100), // Stripe uses cents
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => config('app.frontend_url') . '/payment-callback?success=true&session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => config('app.frontend_url') . '/payment-callback?success=false',
        'metadata' => [
            'booking_id' => $booking->id,
            'user_id' => $booking->user_id,
        ],
    ]);

    return response()->json([
        'success' => true,
        'stripe_session_id' => $session->id,
        'stripe_publishable_key' => env('STRIPE_PUBLISHABLE_KEY'),
        'gateway' => 'stripe',
        'amount' => $amountInSar,
    ]);
}
```

---

### Step 6: Payment Gateway Test Credentials

#### Moyasar (Test Mode)
```env
MOYASAR_API_KEY=pk_test_vcFUHJDBwiyRu4Bd3hFuPpThb6Zf2eMn8wGzxHJ
MOYASAR_SECRET_KEY=sk_test_ZqZySQK8w8GyqhQXSLFqGpbQJGPqrG2kCqCRBcwQ
MOYASAR_TEST_MODE=true

# Test Card
Card: 4111 1111 1111 1111
CVC: 123
Expiry: 12/25
```

#### Telr (Test Mode)
```env
TELR_STORE_ID=25484
TELR_AUTH_KEY=tF@zx^Gq5W
TELR_TEST_MODE=true
```

#### Stripe (Test Mode)
```env
STRIPE_SECRET_KEY=sk_test_...
STRIPE_PUBLISHABLE_KEY=pk_test_...

# Test Card
Card: 4242 4242 4242 4242
CVC: 123
Expiry: 12/25
```

---

### File Locations for Payment System

| File | Purpose | Modification Notes |
|------|---------|-------------------|
| [app/Http/Controllers/Api/PaymentController.php](../app/Http/Controllers/Api/PaymentController.php) | **PRIMARY** - Payment gateway logic | Add gateway methods here |
| [app/Services/PaymentService.php](../app/Services/PaymentService.php) | Stripe processor (legacy) | Can be removed or refactored |
| [config/services.php](../config/services.php) | Gateway credentials | Update env var names |
| [routes/api.php](../routes/api.php) | Webhook routes | Add new gateway webhooks |

---

## 🔄 Integration Workflow: Step-by-Step

### To Switch OTP to Saudi SMS + Keep Moyasar Payment:

**Step 1: Update .env**
```bash
# OTP Settings
OTP_MODE=sms                    # Switch from 'fixed' to 'sms'
SMS_PROVIDER=unifonic           # Add Saudi provider
UNIFONIC_API_KEY=your_key_here
UNIFONIC_SENDER_ID=TILRIMAL

# Payment Settings (KEEP EXISTING)
PAYMENT_GATEWAY=moyasar
MOYASAR_API_KEY=pk_live_...
MOYASAR_SECRET_KEY=sk_live_...
```

**Step 2: Update SmsService.php**
```bash
# Add routing logic to select SMS provider
# See Step 4 in "Integrate Saudi SMS Provider" section above
```

**Step 3: Test OTP**
```bash
# Send OTP to real phone number
curl -X POST http://localhost:8000/api/auth/send-otp \
  -H "Content-Type: application/json" \
  -d '{"phone": "+966501234567", "type": "register"}'

# Check storage/logs/laravel.log for SMS delivery status
```

**Step 4: Test Payment (Stays on Moyasar)**
```bash
# Go to booking page and click "Pay Now"
# Payment flow unchanged - uses Moyasar
# Test with card: 4111 1111 1111 1111
```

---

### To Switch Both OTP & Payment to Different Providers:

**Example: Saudi SMS (Unifonic) + Telr Payment**

**Step 1: Update .env**
```env
OTP_MODE=sms
SMS_PROVIDER=unifonic
UNIFONIC_API_KEY=your_key
UNIFONIC_SENDER_ID=TILRIMAL

PAYMENT_GATEWAY=telr
TELR_STORE_ID=25484
TELR_AUTH_KEY=your_key
TELR_TEST_MODE=false
```

**Step 2: Update SmsService.php** (for Unifonic)
- Add `sendViaUnifonic()` method

**Step 3: Update PaymentController.php** (for Telr)
- Uncomment/update `initiateTelr()` method
- Add logic to route to Telr in `initiate()` method

**Step 4: Verify Webhook Routes**
- Both webhook endpoints exist in [routes/api.php](../routes/api.php):
  - `POST /api/payments/webhook/telr`
  - `POST /api/payments/webhook/moyasar`

---

## 📊 System Architecture Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                    TILRIMAL AUTH & PAYMENT FLOW                  │
├─────────────────────────────────────────────────────────────────┤
│                                                                   │
│  FRONTEND (Next.js)              BACKEND (Laravel)               │
│                                                                   │
│  1. User Registration              AuthController                │
│     ├─ Enter phone                 ├─ register()                 │
│     └─ Click "Register"            └─ Returns: OTP required       │
│                                                                   │
│  2. Send OTP                       OtpController                 │
│     ├─ Trigger send-otp            ├─ send()                     │
│     └─ Input field shown           └─ OtpService (with mode)     │
│                           ↓                                       │
│                        SmsService                                │
│                    ┌──────┬─────────┬──────┐                     │
│                    ↓      ↓         ↓      ↓                     │
│                  Fixed  Random    Twilio Unifonic               │
│                  (Dev)  (Log)   (Intl)  (Saudi)               │
│                                                                   │
│  3. Verify OTP                    OtpController                 │
│     ├─ Input OTP code             ├─ verify()                   │
│     └─ Click "Verify"             └─ Returns: JWT token         │
│                                                                   │
│  4. Booking Submission            ReservationController         │
│     ├─ Fill booking form          ├─ store()                    │
│     ├─ Submit reservation         └─ Creates booking record     │
│     └─ See confirmation                                         │
│                                                                   │
│  5. Payment                       PaymentController             │
│     ├─ Click "Pay Now"            ├─ initiate()                 │
│     ├─ Show payment form          └─ Paymentmodel              │
│                           ↓                                       │
│                      PaymentGateway                              │
│                    ┌──────┬────────┬────────┐                    │
│                    ↓      ↓        ↓        ↓                    │
│                  Moyasar Telr   Stripe  2Checkout              │
│                  (Saudi) (Sau) (USA)  (Intl)                   │
│                                                                   │
│  6. Payment Callback              callback()                    │
│     ├─ User returns from gateway  ├─ verifyPayment()           │
│     └─ See payment status         └─ Updates booking status     │
│                                                                   │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🧪 Testing Checklist

### OTP System Testing

**Fixed Mode (Current)**:
- [ ] POST `/api/auth/send-otp` returns `dev_otp: "1234"`
- [ ] POST `/api/auth/verify-otp` with code `1234` succeeds
- [ ] Wrong code fails with proper error

**Random Mode**:
- [ ] Check `storage/logs/laravel.log` for generated OTP
- [ ] OTP expires after 5 minutes (configurable)
- [ ] Cannot resend within 60 seconds (configurable)

**SMS Mode (After Integration)**:
- [ ] SMS delivered to test phone number
- [ ] SMS contains only OTP code (no metadata)
- [ ] Rate limiting works (can't spam resend)

### Payment System Testing

**Moyasar (Current)**:
- [ ] `/api/payments/initiate` returns Moyasar config
- [ ] Payment form displays correctly
- [ ] Test card `4111 1111 1111 1111` processes
- [ ] Callback updates booking status to `confirmed`

**After Switching Provider**:
- [ ] `/api/payments/initiate` returns correct gateway config
- [ ] Test card for new provider processes
- [ ] Webhook endpoint receives callback
- [ ] Booking payment_status updates correctly

---

## 🚀 Production Deployment Checklist

- [ ] OTP mode changed from `fixed` to `sms`
- [ ] SMS provider credentials configured (Unifonic/Zain)
- [ ] Payment gateway switched to production credentials
- [ ] All webhook URLs registered with payment provider
- [ ] CSRF protection enabled on payment callbacks
- [ ] Rate limiting added to OTP endpoints
- [ ] SMS provider tested with real phone numbers
- [ ] Payment provider tested with live transactions
- [ ] Error logging configured for both systems
- [ ] Monitoring/alerts set up for failed payments
- [ ] Fallback SMS provider configured
- [ ] PCI-DSS compliance verified (no card storage)

---

## 📞 Support

**Questions About OTP?**
- Check logs: `tail -f storage/logs/laravel.log`
- Test endpoint: `POST /api/auth/send-otp`
- Config file: `config/otp.php`

**Questions About Payment?**
- Check logs: `tail -f storage/logs/laravel.log`
- Test endpoint: `POST /api/payments/initiate`
- Provider docs: Moyasar.com, Telr.io

**For Issues During Integration:**
1. Check `.env` variables are correct
2. Verify API credentials with provider
3. Check network connectivity to provider API
4. Review error logs in `storage/logs/`
5. Test with provider's test credentials first

---

**Document Prepared**: January 18, 2026  
**Integration Ready**: ✅ OTP & Payment systems documented  
**Next Steps**: Choose SMS provider, test integration, deploy
