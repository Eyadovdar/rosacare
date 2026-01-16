<?php

namespace Database\Seeders;

use App\Models\Policy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PolicySeeder extends Seeder
{
    public function run(): void
    {
        // Check if policies already exist
        $privacyPolicyExists = Policy::where('slug', 'privacy-policy')->exists();
        $termsOfUseExists = Policy::where('slug', 'terms-of-use')->exists();

        // Privacy Policy - Arabic
        if (!$privacyPolicyExists || !Policy::where('slug', 'privacy-policy')->where('locale', 'ar')->exists()) {
            Policy::updateOrCreate(
                [
                    'slug' => 'privacy-policy',
                    'locale' => 'ar',
                ],
                [
                    'title' => 'سياسة الخصوصية',
                    'content' => $this->getPrivacyPolicyArabicContent(),
                    'is_active' => true,
                ]
            );
        }

        // Privacy Policy - English
        if (!$privacyPolicyExists || !Policy::where('slug', 'privacy-policy')->where('locale', 'en')->exists()) {
            Policy::updateOrCreate(
                [
                    'slug' => 'privacy-policy',
                    'locale' => 'en',
                ],
                [
                    'title' => 'Privacy Policy',
                    'content' => $this->getPrivacyPolicyEnglishContent(),
                    'is_active' => true,
                ]
            );
        }

        // Terms of Use - Arabic
        if (!$termsOfUseExists || !Policy::where('slug', 'terms-of-use')->where('locale', 'ar')->exists()) {
            Policy::updateOrCreate(
                [
                    'slug' => 'terms-of-use',
                    'locale' => 'ar',
                ],
                [
                    'title' => 'شروط الاستخدام',
                    'content' => $this->getTermsOfUseArabicContent(),
                    'is_active' => true,
                ]
            );
        }

        // Terms of Use - English
        if (!$termsOfUseExists || !Policy::where('slug', 'terms-of-use')->where('locale', 'en')->exists()) {
            Policy::updateOrCreate(
                [
                    'slug' => 'terms-of-use',
                    'locale' => 'en',
                ],
                [
                    'title' => 'Terms of Use',
                    'content' => $this->getTermsOfUseEnglishContent(),
                    'is_active' => true,
                ]
            );
        }
    }

    private function getPrivacyPolicyArabicContent(): string
    {
        return <<<'CONTENT'
## 1. مقدمة

مرحباً بك في روزاكير. نحن ملتزمون بحماية خصوصيتك وضمان أمان معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية معلوماتك عند استخدام موقعنا الإلكتروني وخدماتنا.

## 2. المعلومات التي نجمعها

نجمع المعلومات التالية:

• معلومات الهوية: الاسم، عنوان البريد الإلكتروني، رقم الهاتف
• معلومات الدفع: تفاصيل البطاقة الائتمانية أو طرق الدفع الأخرى (يتم معالجتها بشكل آمن من خلال مزودي الدفع الموثوقين)
• معلومات التصفح: عنوان IP، نوع المتصفح، صفحات الويب التي تزورها
• ملفات تعريف الارتباط: نستخدم ملفات تعريف الارتباط لتحسين تجربتك على الموقع

## 3. كيفية استخدام المعلومات

نستخدم معلوماتك للأغراض التالية:

• معالجة الطلبات وإتمام المعاملات
• التواصل معك بشأن طلباتك واستفساراتك
• تحسين خدماتنا وتجربة المستخدم
• إرسال تحديثات وعروض خاصة (بموافقتك)
• الامتثال للمتطلبات القانونية

## 4. مشاركة المعلومات

نحن لا نبيع معلوماتك الشخصية لأطراف ثالثة. قد نشارك معلوماتك فقط مع:

• مزودي الخدمات الموثوقين الذين يساعدوننا في تشغيل موقعنا (مثل معالجة الدفع، الشحن)
• السلطات القانونية عند الحاجة بموجب القانون
• في حالة الاندماج أو الاستحواذ (سيتم إشعارك مسبقاً)

## 5. أمان المعلومات

نتخذ إجراءات أمنية مناسبة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو التغيير أو الكشف أو التدمير. يستخدم موقعنا تشفير SSL لتأمين نقل البيانات.

## 6. ملفات تعريف الارتباط

يستخدم موقعنا ملفات تعريف الارتباط (Cookies) لتحسين تجربة المستخدم. يمكنك إدارة أو تعطيل ملفات تعريف الارتباط من خلال إعدادات المتصفح. يرجى ملاحظة أن تعطيل ملفات تعريف الارتباط قد يؤثر على وظائف الموقع.

## 7. حقوقك

لديك الحق في:

• الوصول إلى معلوماتك الشخصية
• تصحيح المعلومات غير الدقيقة
• حذف معلوماتك الشخصية
• الاعتراض على معالجة معلوماتك
• نقل بياناتك
• سحب الموافقة في أي وقت

## 8. الاحتفاظ بالبيانات

نحتفظ بمعلوماتك الشخصية فقط طالما كانت ضرورية للأغراض المذكورة في هذه السياسة أو حسبما يقتضي القانون. عندما لم تعد المعلومات ضرورية، سنقوم بحذفها بشكل آمن.

## 9. روابط خارجية

قد يحتوي موقعنا على روابط لمواقع خارجية. لا نتحمل مسؤولية ممارسات الخصوصية أو محتوى هذه المواقع. ننصحك بمراجعة سياسات الخصوصية الخاصة بهم.

## 10. التغييرات على سياسة الخصوصية

قد نقوم بتحديث سياسة الخصوصية هذه من وقت لآخر. سنقوم بإشعارك بأي تغييرات جوهرية من خلال نشر السياسة المحدثة على هذه الصفحة وتحديث تاريخ "آخر تحديث".

## 11. الاتصال بنا

إذا كان لديك أي أسئلة أو مخاوف بشأن سياسة الخصوصية هذه، يرجى الاتصال بنا من خلال:

• البريد الإلكتروني: info@rosacare.sy
• الهاتف: +963-XXX-XXX-XXX
• العنوان: سوريا

**آخر تحديث: يناير 2025**
CONTENT;
    }

    private function getPrivacyPolicyEnglishContent(): string
    {
        return <<<'CONTENT'
## 1. Introduction

Welcome to RosaCare. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and protect your information when you use our website and services.

## 2. Information We Collect

We collect the following information:

• Identity Information: Name, email address, phone number
• Payment Information: Credit card details or other payment methods (processed securely through trusted payment providers)
• Browsing Information: IP address, browser type, web pages you visit
• Cookies: We use cookies to enhance your experience on our website

## 3. How We Use Information

We use your information for the following purposes:

• Processing orders and completing transactions
• Communicating with you regarding your orders and inquiries
• Improving our services and user experience
• Sending updates and special offers (with your consent)
• Complying with legal requirements

## 4. Information Sharing

We do not sell your personal information to third parties. We may only share your information with:

• Trusted service providers who help us operate our website (such as payment processing, shipping)
• Legal authorities when required by law
• In case of merger or acquisition (you will be notified in advance)

## 5. Information Security

We take appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. Our website uses SSL encryption to secure data transmission.

## 6. Cookies

Our website uses cookies to enhance user experience. You can manage or disable cookies through your browser settings. Please note that disabling cookies may affect website functionality.

## 7. Your Rights

You have the right to:

• Access your personal information
• Correct inaccurate information
• Delete your personal information
• Object to processing of your information
• Transfer your data
• Withdraw consent at any time

## 8. Data Retention

We retain your personal information only for as long as necessary for the purposes stated in this policy or as required by law. When information is no longer necessary, we will securely delete it.

## 9. External Links

Our website may contain links to external sites. We are not responsible for the privacy practices or content of these sites. We advise you to review their privacy policies.

## 10. Changes to Privacy Policy

We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the updated policy on this page and updating the "Last Updated" date.

## 11. Contact Us

If you have any questions or concerns about this Privacy Policy, please contact us through:

• Email: info@rosacare.sy
• Phone: +963-XXX-XXX-XXX
• Address: Syria

**Last Updated: January 2025**
CONTENT;
    }

    private function getTermsOfUseArabicContent(): string
    {
        return <<<'CONTENT'
## 1. القبول بالشروط

من خلال الوصول إلى موقع روزاكير واستخدامه، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي جزء من هذه الشروط، فيرجى عدم استخدام موقعنا.

## 2. استخدام الموقع

يُسمح لك باستخدام موقعنا للأغراض المشروعة فقط. يجب ألا تستخدم الموقع:

• بطريقة تنتهك أي قوانين أو لوائح محلية أو دولية
• لإرسال أو نقل أي محتوى غير قانوني أو ضار أو مسيء
• لإلحاق الضرر أو محاولة إلحاق الضرر بالموقع أو أمنه
• لجمع المعلومات عن المستخدمين الآخرين
• لأي غرض تجاري غير مصرح به

## 3. الملكية الفكرية

جميع المحتويات الموجودة على هذا الموقع، بما في ذلك النصوص، الرسومات، الشعارات، الصور، مقاطع الفيديو، والتصميم، هي ملك لروزاكير أو المرخصين لها ومحمية بموجب قوانين حقوق النشر والعلامات التجارية. لا يجوز نسخ أو تعديل أو توزيع أو نشر أي محتوى بدون إذن كتابي من روزاكير.

## 4. المنتجات والأسعار

نحاول ضمان دقة المعلومات المتعلقة بالمنتجات والأسعار. ومع ذلك، نحتفظ بالحق في:

• تعديل الأسعار في أي وقت دون إشعار مسبق
• تصحيح أي أخطاء في المعلومات أو الأسعار
• رفض أو إلغاء أي طلبات
• تحديد الكمية المتاحة لكل منتج

## 5. الطلبات والدفع

عند تقديم طلب:

• يجب توفير معلومات دقيقة وكاملة
• المسؤولية عن صحة معلومات الدفع تقع على عاتقك
• نحتفظ بالحق في رفض أي طلب لأي سبب
• الأسعار المعروضة قد تتغير حتى اكتمال الطلب
• يجب أن تكون طرق الدفع المستخدمة مملوكة لك أو مصرح لك باستخدامها

## 6. الشحن والتسليم

• نحن نسعى جاهدين لتسليم الطلبات في الوقت المحدد
• أوقات التسليم هي تقديرية وليست مضمونة
• نحن غير مسؤولين عن التأخيرات الناجمة عن عوامل خارجة عن سيطرتنا
• يجب التحقق من المنتجات عند الاستلام والإبلاغ عن أي أضرار فوراً

## 7. الإرجاع والاسترداد

• يمكن إرجاع المنتجات غير المفتوحة في غضون 14 يوماً من تاريخ الشراء
• يجب أن تكون المنتجات المرتجعة في حالتها الأصلية مع جميع العبوات والوثائق
• نحتفظ بالحق في رفض الإرجاع إذا لم يتم استيفاء الشروط
• سيتم معالجة الاسترداد خلال 7-14 يوماً عمل بعد استلام المنتج المرتجع

## 8. الخصوصية

يتم التعامل مع معلوماتك الشخصية وفقاً لسياسة الخصوصية الخاصة بنا. باستخدام موقعنا، فإنك توافق على جمع واستخدام معلوماتك كما هو موضح في سياسة الخصوصية.

## 9. الروابط الخارجية

قد يحتوي موقعنا على روابط لمواقع خارجية. نحن لسنا مسؤولين عن محتوى أو ممارسات الخصوصية لهذه المواقع. يرجى مراجعة شروط الاستخدام وسياسة الخصوصية الخاصة بهم.

## 10. إخلاء المسؤولية

يُقدم الموقع والخدمات "كما هي" و"حسب التوفر". لا نضمن:

• دقة أو اكتمال المعلومات على الموقع
• أن الموقع سيكون خالياً من الأخطاء أو الفيروسات
• عدم انقطاع أو خلو الموقع من العيوب
• النتائج التي قد تحصل عليها من استخدام الموقع

## 11. الحد من المسؤولية

في أقصى حد يسمح به القانون، لن نكون مسؤولين عن أي أضرار مباشرة أو غير مباشرة أو عرضية أو خاصة أو تبعية ناتجة عن استخدام أو عدم القدرة على استخدام موقعنا أو منتجاتنا.

## 12. الإلغاء

يحق لنا إلغاء أو تعليق وصولك إلى الموقع فوراً، دون إشعار مسبق أو مسؤولية، لأي سبب من الأسباب، بما في ذلك انتهاك هذه الشروط.

## 13. القانون الحاكم

تخضع هذه الشروط والأحكام وتفسر وفقاً لقوانين سوريا. أي نزاعات تنشأ عن أو تتعلق بهذه الشروط يجب حلها في المحاكم المختصة في سوريا.

## 14. التغييرات على الشروط

يحق لنا تعديل هذه الشروط في أي وقت. سنقوم بنشر الشروط المحدثة على هذه الصفحة وتحديث تاريخ "آخر تحديث". استمرار استخدامك للموقع بعد التغييرات يعني موافقتك على الشروط المحدثة.

## 15. الاتصال بنا

إذا كان لديك أي أسئلة حول شروط الاستخدام هذه، يرجى الاتصال بنا من خلال:

• البريد الإلكتروني: info@rosacare.sy
• الهاتف: +963-XXX-XXX-XXX
• العنوان: سوريا

**آخر تحديث: يناير 2025**
CONTENT;
    }

    private function getTermsOfUseEnglishContent(): string
    {
        return <<<'CONTENT'
## 1. Acceptance of Terms

By accessing and using RosaCare website, you agree to comply with these terms and conditions. If you do not agree with any part of these terms, please do not use our website.

## 2. Use of Website

You are permitted to use our website for lawful purposes only. You must not use the website:

• In any way that violates any local or international laws or regulations
• To transmit or send any unlawful, harmful, or offensive content
• To harm or attempt to harm the website or its security
• To collect information about other users
• For any unauthorized commercial purpose

## 3. Intellectual Property

All content on this website, including text, graphics, logos, images, videos, and design, is the property of RosaCare or its licensors and is protected by copyright and trademark laws. No content may be copied, modified, distributed, or published without written permission from RosaCare.

## 4. Products and Prices

We strive to ensure the accuracy of information regarding products and prices. However, we reserve the right to:

• Modify prices at any time without prior notice
• Correct any errors in information or prices
• Refuse or cancel any orders
• Limit the quantity available for each product

## 5. Orders and Payment

When placing an order:

• You must provide accurate and complete information
• You are responsible for the accuracy of payment information
• We reserve the right to refuse any order for any reason
• Prices displayed may change until order completion
• Payment methods used must be owned by you or authorized for your use

## 6. Shipping and Delivery

• We strive to deliver orders on time
• Delivery times are estimates and not guaranteed
• We are not responsible for delays caused by factors beyond our control
• Products must be verified upon receipt and any damages reported immediately

## 7. Returns and Refunds

• Unopened products can be returned within 14 days of purchase date
• Returned products must be in their original condition with all packaging and documentation
• We reserve the right to refuse returns if conditions are not met
• Refunds will be processed within 7-14 business days after receiving the returned product

## 8. Privacy

Your personal information is handled according to our Privacy Policy. By using our website, you agree to the collection and use of your information as described in the Privacy Policy.

## 9. External Links

Our website may contain links to external sites. We are not responsible for the content or privacy practices of these sites. Please review their terms of use and privacy policy.

## 10. Disclaimer

The website and services are provided "as is" and "as available". We do not guarantee:

• The accuracy or completeness of information on the website
• That the website will be free from errors or viruses
• Uninterrupted or defect-free operation of the website
• Results that may be obtained from using the website

## 11. Limitation of Liability

To the maximum extent permitted by law, we shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from the use or inability to use our website or products.

## 12. Termination

We reserve the right to terminate or suspend your access to the website immediately, without prior notice or liability, for any reason, including breach of these terms.

## 13. Governing Law

These terms and conditions are governed by and construed in accordance with the laws of Syria. Any disputes arising from or related to these terms shall be resolved in the competent courts of Syria.

## 14. Changes to Terms

We reserve the right to modify these terms at any time. We will post the updated terms on this page and update the "Last Updated" date. Your continued use of the website after changes indicates your acceptance of the updated terms.

## 15. Contact Us

If you have any questions about these Terms of Use, please contact us through:

• Email: info@rosacare.sy
• Phone: +963-XXX-XXX-XXX
• Address: Syria

**Last Updated: January 2025**
CONTENT;
    }
}

