import { Head, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { useEffect, useState } from 'react';

interface PrivacyPolicyProps {
    locale?: string;
}

export default function PrivacyPolicy({ locale = 'ar' }: PrivacyPolicyProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        setIsVisible(true);
    }, []);

    const content = locale === 'ar' ? {
        title: 'سياسة الخصوصية',
        lastUpdated: 'آخر تحديث: يناير 2025',
        sections: [
            {
                title: '1. مقدمة',
                content: 'مرحباً بك في روزاكير. نحن ملتزمون بحماية خصوصيتك وضمان أمان معلوماتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية معلوماتك عند استخدام موقعنا الإلكتروني وخدماتنا.'
            },
            {
                title: '2. المعلومات التي نجمعها',
                content: 'نجمع المعلومات التالية:\n\n• معلومات الهوية: الاسم، عنوان البريد الإلكتروني، رقم الهاتف\n• معلومات الدفع: تفاصيل البطاقة الائتمانية أو طرق الدفع الأخرى (يتم معالجتها بشكل آمن من خلال مزودي الدفع الموثوقين)\n• معلومات التصفح: عنوان IP، نوع المتصفح، صفحات الويب التي تزورها\n• ملفات تعريف الارتباط: نستخدم ملفات تعريف الارتباط لتحسين تجربتك على الموقع'
            },
            {
                title: '3. كيفية استخدام المعلومات',
                content: 'نستخدم معلوماتك للأغراض التالية:\n\n• معالجة الطلبات وإتمام المعاملات\n• التواصل معك بشأن طلباتك واستفساراتك\n• تحسين خدماتنا وتجربة المستخدم\n• إرسال تحديثات وعروض خاصة (بموافقتك)\n• الامتثال للمتطلبات القانونية'
            },
            {
                title: '4. مشاركة المعلومات',
                content: 'نحن لا نبيع معلوماتك الشخصية لأطراف ثالثة. قد نشارك معلوماتك فقط مع:\n\n• مزودي الخدمات الموثوقين الذين يساعدوننا في تشغيل موقعنا (مثل معالجة الدفع، الشحن)\n• السلطات القانونية عند الحاجة بموجب القانون\n• في حالة الاندماج أو الاستحواذ (سيتم إشعارك مسبقاً)'
            },
            {
                title: '5. أمان المعلومات',
                content: 'نتخذ إجراءات أمنية مناسبة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو التغيير أو الكشف أو التدمير. يستخدم موقعنا تشفير SSL لتأمين نقل البيانات.'
            },
            {
                title: '6. ملفات تعريف الارتباط',
                content: 'يستخدم موقعنا ملفات تعريف الارتباط (Cookies) لتحسين تجربة المستخدم. يمكنك إدارة أو تعطيل ملفات تعريف الارتباط من خلال إعدادات المتصفح. يرجى ملاحظة أن تعطيل ملفات تعريف الارتباط قد يؤثر على وظائف الموقع.'
            },
            {
                title: '7. حقوقك',
                content: 'لديك الحق في:\n\n• الوصول إلى معلوماتك الشخصية\n• تصحيح المعلومات غير الدقيقة\n• حذف معلوماتك الشخصية\n• الاعتراض على معالجة معلوماتك\n• نقل بياناتك\n• سحب الموافقة في أي وقت'
            },
            {
                title: '8. الاحتفاظ بالبيانات',
                content: 'نحتفظ بمعلوماتك الشخصية فقط طالما كانت ضرورية للأغراض المذكورة في هذه السياسة أو حسبما يقتضي القانون. عندما لم تعد المعلومات ضرورية، سنقوم بحذفها بشكل آمن.'
            },
            {
                title: '9. روابط خارجية',
                content: 'قد يحتوي موقعنا على روابط لمواقع خارجية. لا نتحمل مسؤولية ممارسات الخصوصية أو محتوى هذه المواقع. ننصحك بمراجعة سياسات الخصوصية الخاصة بهم.'
            },
            {
                title: '10. التغييرات على سياسة الخصوصية',
                content: 'قد نقوم بتحديث سياسة الخصوصية هذه من وقت لآخر. سنقوم بإشعارك بأي تغييرات جوهرية من خلال نشر السياسة المحدثة على هذه الصفحة وتحديث تاريخ "آخر تحديث".'
            },
            {
                title: '11. الاتصال بنا',
                content: 'إذا كان لديك أي أسئلة أو مخاوف بشأن سياسة الخصوصية هذه، يرجى الاتصال بنا من خلال:\n\n• البريد الإلكتروني: info@rosacare.sy\n• الهاتف: +963-XXX-XXX-XXX\n• العنوان: سوريا'
            }
        ]
    } : {
        title: 'Privacy Policy',
        lastUpdated: 'Last Updated: January 2025',
        sections: [
            {
                title: '1. Introduction',
                content: 'Welcome to RosaCare. We are committed to protecting your privacy and ensuring the security of your personal information. This Privacy Policy explains how we collect, use, and protect your information when you use our website and services.'
            },
            {
                title: '2. Information We Collect',
                content: 'We collect the following information:\n\n• Identity Information: Name, email address, phone number\n• Payment Information: Credit card details or other payment methods (processed securely through trusted payment providers)\n• Browsing Information: IP address, browser type, web pages you visit\n• Cookies: We use cookies to enhance your experience on our website'
            },
            {
                title: '3. How We Use Information',
                content: 'We use your information for the following purposes:\n\n• Processing orders and completing transactions\n• Communicating with you regarding your orders and inquiries\n• Improving our services and user experience\n• Sending updates and special offers (with your consent)\n• Complying with legal requirements'
            },
            {
                title: '4. Information Sharing',
                content: 'We do not sell your personal information to third parties. We may only share your information with:\n\n• Trusted service providers who help us operate our website (such as payment processing, shipping)\n• Legal authorities when required by law\n• In case of merger or acquisition (you will be notified in advance)'
            },
            {
                title: '5. Information Security',
                content: 'We take appropriate security measures to protect your personal information from unauthorized access, alteration, disclosure, or destruction. Our website uses SSL encryption to secure data transmission.'
            },
            {
                title: '6. Cookies',
                content: 'Our website uses cookies to enhance user experience. You can manage or disable cookies through your browser settings. Please note that disabling cookies may affect website functionality.'
            },
            {
                title: '7. Your Rights',
                content: 'You have the right to:\n\n• Access your personal information\n• Correct inaccurate information\n• Delete your personal information\n• Object to processing of your information\n• Transfer your data\n• Withdraw consent at any time'
            },
            {
                title: '8. Data Retention',
                content: 'We retain your personal information only for as long as necessary for the purposes stated in this policy or as required by law. When information is no longer necessary, we will securely delete it.'
            },
            {
                title: '9. External Links',
                content: 'Our website may contain links to external sites. We are not responsible for the privacy practices or content of these sites. We advise you to review their privacy policies.'
            },
            {
                title: '10. Changes to Privacy Policy',
                content: 'We may update this Privacy Policy from time to time. We will notify you of any material changes by posting the updated policy on this page and updating the "Last Updated" date.'
            },
            {
                title: '11. Contact Us',
                content: 'If you have any questions or concerns about this Privacy Policy, please contact us through:\n\n• Email: info@rosacare.sy\n• Phone: +963-XXX-XXX-XXX\n• Address: Syria'
            }
        ]
    };

    return (
        <>
            <Head title={`${content.title} - RosaCare`} />
            <style>{`
                @keyframes fadeInUp {
                    from {
                        opacity: 0;
                        transform: translateY(30px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                .fade-in-up {
                    animation: fadeInUp 0.8s ease-out both;
                }
            `}</style>
            <div className={`min-h-screen bg-gradient-to-br from-secondary/50 to-background ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20">
                    <div className="container mx-auto px-4 max-w-4xl">
                        <div className={`fade-in-up ${isVisible ? 'opacity-100' : 'opacity-0'}`}>
                            <div className="bg-background/80 backdrop-blur-sm rounded-2xl p-8 md:p-12 shadow-xl border border-border" style={{
                                boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                            }}>
                                <h1 className="text-4xl md:text-5xl font-bold mb-4 text-center" style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#862b90',
                                    letterSpacing: '0.05em'
                                }}>
                                    {content.title}
                                </h1>
                                <p className="text-center text-muted-foreground mb-8" style={{
                                    fontFamily: "'Alexandria', sans-serif"
                                }}>
                                    {content.lastUpdated}
                                </p>
                                <div className="prose prose-lg max-w-none" style={{
                                    fontFamily: "'Alexandria', sans-serif"
                                }}>
                                    {content.sections.map((section, index) => (
                                        <div key={index} className="mb-8">
                                            <h2 className="text-2xl font-semibold mb-4" style={{
                                                color: '#e72177',
                                                fontFamily: "'Alexandria', sans-serif",
                                                letterSpacing: '0.05em'
                                            }}>
                                                {section.title}
                                            </h2>
                                            <p className="text-base md:text-lg leading-relaxed whitespace-pre-line" style={{
                                                color: '#545759',
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 300,
                                                lineHeight: '1.8'
                                            }}>
                                                {section.content}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <Footer locale={locale} />
            </div>
        </>
    );
}

