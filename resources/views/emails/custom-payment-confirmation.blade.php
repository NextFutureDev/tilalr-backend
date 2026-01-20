<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation - Tilal Rimal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header .logo {
            font-size: 32px;
            margin-bottom: 10px;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background: #48bb78;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: -40px auto 20px;
            border: 4px solid white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }
        .success-icon svg {
            width: 40px;
            height: 40px;
            fill: white;
        }
        .content {
            padding: 20px 30px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .payment-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #667eea;
        }
        .payment-details h2 {
            margin: 0 0 15px;
            font-size: 16px;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #666;
            font-weight: 500;
        }
        .detail-value {
            color: #333;
            font-weight: 600;
            text-align: right;
        }
        .amount-row {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .amount-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
        }
        .amount-value {
            font-size: 28px;
            font-weight: 700;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer .company {
            font-weight: 600;
            color: #667eea;
        }
        .note {
            background-color: #e8f5e9;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #2e7d32;
            text-align: center;
        }
        .note strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">🏜️</div>
            <h1>Tilal Rimal</h1>
        </div>
        
        <div class="content">
            <div style="text-align: center;">
                <div class="success-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                </div>
            </div>
            
            <div class="greeting">
                Dear <strong>{{ $customer_name }}</strong>,<br>
                Your payment has been successfully received!
            </div>
            
            <div class="amount-row">
                <div class="amount-label">Amount Paid</div>
                <div class="amount-value">{{ $amount }} SAR</div>
            </div>
            
            <div class="payment-details">
                <h2>Payment Details</h2>
                <div class="detail-row">
                    <span class="detail-label">Description</span>
                    <span class="detail-value">{{ $description }}</span>
                </div>
                @if($transaction_id)
                <div class="detail-row">
                    <span class="detail-label">Transaction ID</span>
                    <span class="detail-value">{{ $transaction_id }}</span>
                </div>
                @endif
                <div class="detail-row">
                    <span class="detail-label">Date & Time</span>
                    <span class="detail-value">{{ $date }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Status</span>
                    <span class="detail-value" style="color: #48bb78;">✓ Paid</span>
                </div>
            </div>
            
            <div class="note">
                <strong>Thank you for your payment!</strong>
                Please keep this email as your receipt. If you have any questions, don't hesitate to contact us.
            </div>
        </div>
        
        <div class="footer">
            <p class="company">Tilal Rimal</p>
            <p>Thank you for choosing our services</p>
            <p style="font-size: 12px; color: #999;">This is an automated email. Please do not reply directly.</p>
        </div>
    </div>
</body>
</html>
