<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding 0;}
        .container {max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px overflow; hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);}
        .header {background: #2563eb; color: white; padding: 32px; text-align center;}
        .header h1 {margin: 0; font-size: 24px;}
        .body {padding: 32px;}
        .body p {color: #374151; line-height: 1.6;}
        .credentials{ background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .credentials p { margin: 8px 0; color #111827; }
        .credentials strong { color: #2563eb; }
        .btn {display: inline-block; background: #2563eb; color:white; padding: 12px 24px; border-radius: 6px; text-decoration: none; margin: 16px 0; }
        .warning { background: #fef3c7; border: 1px solid #f59e0b; border-radius: 6px; padding: 12px 16px; margin: 16px 0; }
        .warning p {color: #92400e; margin: 0; font-size: 14px; }
        .footer {background: #f9fafb; padding: 20px 32px; text-align: center; }
        .footer p {color: #9ca3af; font-size: 12px; margin: 0; }
        </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> HR Management System </h1>
            <p style="margin:8px 0 0; opacity:0.85;"> Account Approved</p>
</div>
    <div class="body">
        <p> Hello, <strong> {{ $recipientName }}</strong>!</p>
        <p>
            Your account request for the <strong>{{ ucfirst($role) }}</strong> role
            has been <strong style="color: #16a34a;">approved</strong>
            Here are your login credentials:
</p>

    <div class="credentials">
        <p><strong>Login URL:</strong> {{ url('/login') }}</p>
        <p><strong>Email:</strong>{{ $recipientEmail }}</p>
        <p><strong>Temporary Password:</strong>{{ $generatedPassword }}</p>
        <p><strong>Role:</strong>{{ ucfirst($role) }}</p>
</div>
    <div class="warning">
        <p>⚠️ You will be required to change your password upon first login. Please keep your credentials secure.</p>
</div>
    <a href="{{ url('/login') }}" class="btn">Login to HR System</a>
    <p style="color: #6b7280; font-size:14px;">
        If you did not request this account, please ignore this email
        or contact your administrator immediately.
</p>
</div>
<div class="footer">
    <p>© {{ date('Y') }} HR Management System. All rights reserved.</p>
</div>
</div>
</body>
</html>