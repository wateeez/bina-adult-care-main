<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - Bina Adult Care</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2c5282;
            margin: 0;
        }
        .code-box {
            background-color: #edf2f7;
            border: 2px dashed #2c5282;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #2c5282;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .info {
            background-color: #fff5f5;
            border-left: 4px solid #fc8181;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🔐 Two-Factor Authentication</h1>
            <p>Bina Adult Care Admin Panel</p>
        </div>

        <p>Hello {{ $name }},</p>

        <p>You are attempting to log in to the Bina Adult Care admin panel. Please use the following verification code to complete your login:</p>

        <div class="code-box">
            <div class="code">{{ $code }}</div>
        </div>

        <div class="info">
            <strong>⏰ Important:</strong> This code will expire in <strong>10 minutes</strong>.
        </div>

        <p><strong>Security Tips:</strong></p>
        <ul>
            <li>Never share this code with anyone</li>
            <li>If you didn't attempt to log in, please ignore this email</li>
            <li>Contact the super admin if you suspect unauthorized access</li>
        </ul>

        <div class="footer">
            <p>This is an automated email from Bina Adult Care Admin System</p>
            <p>&copy; {{ date('Y') }} Bina Adult Care. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
