<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 30px; border: 1px solid #e0e0e0; border-radius: 12px; background-color: #ffffff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); }
        .header { text-align: center; border-bottom: 2px solid #f0f0f0; padding-bottom: 20px; margin-bottom: 25px; }
        .header h2 { margin: 0; color: #d63384; font-size: 24px; font-weight: 700; }
        .greeting { font-size: 16px; font-weight: 600; color: #333333; }
        .message { font-size: 15px; color: #555555; }
        .otp-container { text-align: center; margin: 30px 0; }
        .otp { font-size: 32px; font-weight: 800; color: #d63384; letter-spacing: 6px; display: inline-block; background: #fff0f6; padding: 15px 40px; border-radius: 8px; border: 1px dashed #d63384; }
        .expiry-note { font-size: 13px; color: #888888; text-align: center; margin-top: 10px; }
        .footer { font-size: 12px; color: #aaaaaa; text-align: center; border-top: 1px solid #f0f0f0; padding-top: 20px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Kasar Community Matrimony</h2>
        </div>
        <p class="greeting">Hello,</p>
        <p class="message">You requested a One-Time Password (OTP) for your <strong>{{ $type }}</strong> request on our platform.</p>
        <div class="otp-container">
            <div class="otp">{{ $otp }}</div>
            <p class="expiry-note">This code is valid for 10-15 minutes. Please do not share this OTP with anyone.</p>
        </div>
        <p class="message">Thank you,<br>The Kasar Community Matrimony Team</p>
        <div class="footer">
            This is an automated email. Please do not reply directly to this message.
        </div>
    </div>
</body>
</html>
