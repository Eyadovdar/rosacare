<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $locale === 'ar' ? 'رمز التحقق' : 'Verification Code' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #e72177 0%, #862c91 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .code-box {
            background: white;
            border: 3px solid #e72177;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            color: #e72177;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 12px;
            background: #f9f9f9;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $locale === 'ar' ? 'رمز التحقق لتقديم طلب الوظيفة' : 'Position Application Verification Code' }}</h1>
    </div>
    
    <div class="content">
        @if($locale === 'ar')
            <p>مرحباً،</p>
            <p>شكراً لك على اهتمامك بالانضمام إلى فريق روزاكير. يرجى استخدام رمز التحقق التالي لإتمام عملية تقديم طلبك:</p>
            
            <div class="code-box">
                <div class="code">{{ $code }}</div>
            </div>
            
            <p><strong>ملاحظة مهمة:</strong></p>
            <ul>
                <li>هذا الرمز صالح لمدة 15 دقيقة فقط</li>
                <li>لا تشارك هذا الرمز مع أي شخص آخر</li>
                <li>إذا لم تطلب هذا الرمز، يرجى تجاهل هذا البريد الإلكتروني</li>
            </ul>
            
            <p>بعد إدخال الرمز بنجاح، ستتمكن من إكمال تقديم طلبك.</p>
        @else
            <p>Hello,</p>
            <p>Thank you for your interest in joining the RosaCare team. Please use the following verification code to complete your application:</p>
            
            <div class="code-box">
                <div class="code">{{ $code }}</div>
            </div>
            
            <p><strong>Important Notes:</strong></p>
            <ul>
                <li>This code is valid for 15 minutes only</li>
                <li>Do not share this code with anyone else</li>
                <li>If you did not request this code, please ignore this email</li>
            </ul>
            
            <p>After successfully entering the code, you will be able to complete your application submission.</p>
        @endif
    </div>
    
    <div class="footer">
        <p>{{ $locale === 'ar' ? 'هذه رسالة آلية من موقع روزاكير.' : 'This is an automated message from RosaCare website.' }}</p>
    </div>
</body>
</html>

