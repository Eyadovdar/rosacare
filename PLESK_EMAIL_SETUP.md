# إعداد البريد الإلكتروني على Plesk Shared Hosting

## المشاكل الشائعة مع Plesk Shared Hosting

عند رفع التطبيق على Plesk shared hosting، قد تواجه مشاكل في إرسال البريد الإلكتروني. هذا الملف يشرح الحلول الموصى بها.

## الإعدادات المطلوبة في ملف `.env`

### 1. إعدادات SMTP الأساسية

```env
MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=587
MAIL_USERNAME=your-email@yourdomain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. ملاحظات مهمة:

- **MAIL_HOST**: استخدم `localhost` بدلاً من اسم الخادم (مثل `mail.yourdomain.com`)
- **MAIL_PORT**: 
  - استخدم `587` مع `tls` (موصى به)
  - أو `465` مع `ssl` (إذا كان الخادم يدعمه فقط)
- **MAIL_USERNAME**: يجب أن يكون عنوان البريد الإلكتروني الكامل (مثل `me@yourdomain.com`)
- **MAIL_PASSWORD**: كلمة مرور البريد الإلكتروني (ليست كلمة مرور Plesk)
- **MAIL_FROM_ADDRESS**: يجب أن يطابق `MAIL_USERNAME` تماماً

### 3. إعدادات إضافية (اختيارية)

```env
MAIL_TIMEOUT=30
MAIL_EHLO_DOMAIN=yourdomain.com
```

## خطوات الإعداد على Plesk

### 1. إنشاء صندوق بريد إلكتروني في Plesk

1. سجل الدخول إلى Plesk Panel
2. اذهب إلى **Mail** > **Mailboxes**
3. أنشئ صندوق بريد جديد أو استخدم موجود
4. تأكد من تفعيل البريد الإلكتروني

### 2. الحصول على كلمة المرور

- استخدم كلمة مرور صندوق البريد (ليست كلمة مرور Plesk)
- إذا نسيت كلمة المرور، يمكنك إعادة تعيينها من Plesk

### 3. التحقق من إعدادات SMTP

- **SMTP Server**: `localhost` أو `127.0.0.1`
- **Port**: `587` (TLS) أو `465` (SSL)
- **Encryption**: TLS أو SSL حسب المنفذ

## اختبار الإعدادات

### طريقة 1: استخدام Route الاختبار

بعد رفع التطبيق، يمكنك زيارة:
```
https://yourdomain.com/test-email
```

هذا سيرسل بريد إلكتروني اختباري إلى العنوان المحدد في `.env`.

### طريقة 2: استخدام Tinker

```bash
php artisan tinker
```

ثم في Tinker:
```php
Mail::raw('Test email', function ($message) {
    $message->to('test@example.com')
            ->subject('Test Email');
});
```

### طريقة 3: من خلال التطبيق

استخدم نموذج التقديم على الوظائف أو نموذج الاتصال لاختبار الإرسال.

## حل المشاكل الشائعة

### خطأ: "Connection timeout"

**الحل:**
- تأكد من استخدام `localhost` كـ `MAIL_HOST`
- تحقق من أن المنفذ صحيح (`587` أو `465`)
- تأكد من أن التشفير يطابق المنفذ (`tls` لـ `587`، `ssl` لـ `465`)

### خطأ: "Authentication failed"

**الحل:**
- تأكد من أن `MAIL_USERNAME` هو عنوان البريد الكامل
- تأكد من أن `MAIL_PASSWORD` صحيحة
- تأكد من أن `MAIL_FROM_ADDRESS` يطابق `MAIL_USERNAME`

### خطأ: "Your domain is not allowed in header From"

**الحل:**
- تأكد من أن `MAIL_FROM_ADDRESS` يطابق `MAIL_USERNAME` تماماً
- تأكد من أن البريد الإلكتروني موجود في Plesk

### خطأ: "SSL certificate problem"

**الحل:**
- تم إضافة إعدادات SSL في `config/mail.php` لتعطيل التحقق من الشهادة
- إذا استمرت المشكلة، جرب استخدام `tls` بدلاً من `ssl`

## إعدادات متقدمة

إذا كنت تستخدم منفذ `465` مع `ssl`:

```env
MAIL_PORT=465
MAIL_ENCRYPTION=ssl
```

إذا كنت تستخدم منفذ `587` مع `tls`:

```env
MAIL_PORT=587
MAIL_ENCRYPTION=tls
```

## التحقق من السجلات

بعد محاولة الإرسال، تحقق من:
- `storage/logs/laravel.log` للأخطاء
- سجلات Plesk Mail (إذا كانت متاحة)

## ملاحظات إضافية

1. **Timeout**: تم تعيين timeout افتراضي إلى 30 ثانية. يمكنك تغييره عبر `MAIL_TIMEOUT` في `.env`
2. **SSL Verification**: تم تعطيل التحقق من الشهادة SSL في الإعدادات لتحسين التوافق مع Plesk
3. **From Address**: الكود يستخدم `MAIL_USERNAME` كعنوان `From` تلقائياً لتجنب مشاكل SMTP

## الدعم

إذا استمرت المشاكل:
1. تحقق من سجلات Laravel: `storage/logs/laravel.log`
2. تحقق من إعدادات البريد في Plesk
3. تأكد من أن صندوق البريد نشط وليس معطلاً
4. جرب استخدام `sendmail` بدلاً من SMTP (إذا كان متاحاً)

