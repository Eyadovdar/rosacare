import { Head, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { useEffect, useState } from 'react';

interface TermsOfUseProps {
    locale?: string;
}

export default function TermsOfUse({ locale = 'ar' }: TermsOfUseProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const [isVisible, setIsVisible] = useState(false);

    useEffect(() => {
        setIsVisible(true);
    }, []);

    const content = locale === 'ar' ? {
        title: 'شروط الاستخدام',
        lastUpdated: 'آخر تحديث: يناير 2025',
        sections: [
            {
                title: '1. القبول بالشروط',
                content: 'من خلال الوصول إلى موقع روزاكير واستخدامه، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي جزء من هذه الشروط، فيرجى عدم استخدام موقعنا.'
            },
            {
                title: '2. استخدام الموقع',
                content: 'يُسمح لك باستخدام موقعنا للأغراض المشروعة فقط. يجب ألا تستخدم الموقع:\n\n• بطريقة تنتهك أي قوانين أو لوائح محلية أو دولية\n• لإرسال أو نقل أي محتوى غير قانوني أو ضار أو مسيء\n• لإلحاق الضرر أو محاولة إلحاق الضرر بالموقع أو أمنه\n• لجمع المعلومات عن المستخدمين الآخرين\n• لأي غرض تجاري غير مصرح به'
            },
            {
                title: '3. الملكية الفكرية',
                content: 'جميع المحتويات الموجودة على هذا الموقع، بما في ذلك النصوص، الرسومات، الشعارات، الصور، مقاطع الفيديو، والتصميم، هي ملك لروزاكير أو المرخصين لها ومحمية بموجب قوانين حقوق النشر والعلامات التجارية. لا يجوز نسخ أو تعديل أو توزيع أو نشر أي محتوى بدون إذن كتابي من روزاكير.'
            },
            {
                title: '4. المنتجات والأسعار',
                content: 'نحاول ضمان دقة المعلومات المتعلقة بالمنتجات والأسعار. ومع ذلك، نحتفظ بالحق في:\n\n• تعديل الأسعار في أي وقت دون إشعار مسبق\n• تصحيح أي أخطاء في المعلومات أو الأسعار\n• رفض أو إلغاء أي طلبات\n• تحديد الكمية المتاحة لكل منتج'
            },
            {
                title: '5. الطلبات والدفع',
                content: 'عند تقديم طلب:\n\n• يجب توفير معلومات دقيقة وكاملة\n• المسؤولية عن صحة معلومات الدفع تقع على عاتقك\n• نحتفظ بالحق في رفض أي طلب لأي سبب\n• الأسعار المعروضة قد تتغير حتى اكتمال الطلب\n• يجب أن تكون طرق الدفع المستخدمة مملوكة لك أو مصرح لك باستخدامها'
            },
            {
                title: '6. الشحن والتسليم',
                content: '• نحن نسعى جاهدين لتسليم الطلبات في الوقت المحدد\n• أوقات التسليم هي تقديرية وليست مضمونة\n• نحن غير مسؤولين عن التأخيرات الناجمة عن عوامل خارجة عن سيطرتنا\n• يجب التحقق من المنتجات عند الاستلام والإبلاغ عن أي أضرار فوراً'
            },
            {
                title: '7. الإرجاع والاسترداد',
                content: '• يمكن إرجاع المنتجات غير المفتوحة في غضون 14 يوماً من تاريخ الشراء\n• يجب أن تكون المنتجات المرتجعة في حالتها الأصلية مع جميع العبوات والوثائق\n• نحتفظ بالحق في رفض الإرجاع إذا لم يتم استيفاء الشروط\n• سيتم معالجة الاسترداد خلال 7-14 يوماً عمل بعد استلام المنتج المرتجع'
            },
            {
                title: '8. الخصوصية',
                content: 'يتم التعامل مع معلوماتك الشخصية وفقاً لسياسة الخصوصية الخاصة بنا. باستخدام موقعنا، فإنك توافق على جمع واستخدام معلوماتك كما هو موضح في سياسة الخصوصية.'
            },
            {
                title: '9. الروابط الخارجية',
                content: 'قد يحتوي موقعنا على روابط لمواقع خارجية. نحن لسنا مسؤولين عن محتوى أو ممارسات الخصوصية لهذه المواقع. يرجى مراجعة شروط الاستخدام وسياسة الخصوصية الخاصة بهم.'
            },
            {
                title: '10. إخلاء المسؤولية',
                content: 'يُقدم الموقع والخدمات "كما هي" و"حسب التوفر". لا نضمن:\n\n• دقة أو اكتمال المعلومات على الموقع\n• أن الموقع سيكون خالياً من الأخطاء أو الفيروسات\n• عدم انقطاع أو خلو الموقع من العيوب\n• النتائج التي قد تحصل عليها من استخدام الموقع'
            },
            {
                title: '11. الحد من المسؤولية',
                content: 'في أقصى حد يسمح به القانون، لن نكون مسؤولين عن أي أضرار مباشرة أو غير مباشرة أو عرضية أو خاصة أو تبعية ناتجة عن استخدام أو عدم القدرة على استخدام موقعنا أو منتجاتنا.'
            },
            {
                title: '12. الإلغاء',
                content: 'يحق لنا إلغاء أو تعليق وصولك إلى الموقع فوراً، دون إشعار مسبق أو مسؤولية، لأي سبب من الأسباب، بما في ذلك انتهاك هذه الشروط.'
            },
            {
                title: '13. القانون الحاكم',
                content: 'تخضع هذه الشروط والأحكام وتفسر وفقاً لقوانين سوريا. أي نزاعات تنشأ عن أو تتعلق بهذه الشروط يجب حلها في المحاكم المختصة في سوريا.'
            },
            {
                title: '14. التغييرات على الشروط',
                content: 'يحق لنا تعديل هذه الشروط في أي وقت. سنقوم بنشر الشروط المحدثة على هذه الصفحة وتحديث تاريخ "آخر تحديث". استمرار استخدامك للموقع بعد التغييرات يعني موافقتك على الشروط المحدثة.'
            },
            {
                title: '15. الاتصال بنا',
                content: 'إذا كان لديك أي أسئلة حول شروط الاستخدام هذه، يرجى الاتصال بنا من خلال:\n\n• البريد الإلكتروني: info@rosacare.sy\n• الهاتف: +963-XXX-XXX-XXX\n• العنوان: سوريا'
            }
        ]
    } : {
        title: 'Terms of Use',
        lastUpdated: 'Last Updated: January 2025',
        sections: [
            {
                title: '1. Acceptance of Terms',
                content: 'By accessing and using RosaCare website, you agree to comply with these terms and conditions. If you do not agree with any part of these terms, please do not use our website.'
            },
            {
                title: '2. Use of Website',
                content: 'You are permitted to use our website for lawful purposes only. You must not use the website:\n\n• In any way that violates any local or international laws or regulations\n• To transmit or send any unlawful, harmful, or offensive content\n• To harm or attempt to harm the website or its security\n• To collect information about other users\n• For any unauthorized commercial purpose'
            },
            {
                title: '3. Intellectual Property',
                content: 'All content on this website, including text, graphics, logos, images, videos, and design, is the property of RosaCare or its licensors and is protected by copyright and trademark laws. No content may be copied, modified, distributed, or published without written permission from RosaCare.'
            },
            {
                title: '4. Products and Prices',
                content: 'We strive to ensure the accuracy of information regarding products and prices. However, we reserve the right to:\n\n• Modify prices at any time without prior notice\n• Correct any errors in information or prices\n• Refuse or cancel any orders\n• Limit the quantity available for each product'
            },
            {
                title: '5. Orders and Payment',
                content: 'When placing an order:\n\n• You must provide accurate and complete information\n• You are responsible for the accuracy of payment information\n• We reserve the right to refuse any order for any reason\n• Prices displayed may change until order completion\n• Payment methods used must be owned by you or authorized for your use'
            },
            {
                title: '6. Shipping and Delivery',
                content: '• We strive to deliver orders on time\n• Delivery times are estimates and not guaranteed\n• We are not responsible for delays caused by factors beyond our control\n• Products must be verified upon receipt and any damages reported immediately'
            },
            {
                title: '7. Returns and Refunds',
                content: '• Unopened products can be returned within 14 days of purchase date\n• Returned products must be in their original condition with all packaging and documentation\n• We reserve the right to refuse returns if conditions are not met\n• Refunds will be processed within 7-14 business days after receiving the returned product'
            },
            {
                title: '8. Privacy',
                content: 'Your personal information is handled according to our Privacy Policy. By using our website, you agree to the collection and use of your information as described in the Privacy Policy.'
            },
            {
                title: '9. External Links',
                content: 'Our website may contain links to external sites. We are not responsible for the content or privacy practices of these sites. Please review their terms of use and privacy policy.'
            },
            {
                title: '10. Disclaimer',
                content: 'The website and services are provided "as is" and "as available". We do not guarantee:\n\n• The accuracy or completeness of information on the website\n• That the website will be free from errors or viruses\n• Uninterrupted or defect-free operation of the website\n• Results that may be obtained from using the website'
            },
            {
                title: '11. Limitation of Liability',
                content: 'To the maximum extent permitted by law, we shall not be liable for any direct, indirect, incidental, special, or consequential damages resulting from the use or inability to use our website or products.'
            },
            {
                title: '12. Termination',
                content: 'We reserve the right to terminate or suspend your access to the website immediately, without prior notice or liability, for any reason, including breach of these terms.'
            },
            {
                title: '13. Governing Law',
                content: 'These terms and conditions are governed by and construed in accordance with the laws of Syria. Any disputes arising from or related to these terms shall be resolved in the competent courts of Syria.'
            },
            {
                title: '14. Changes to Terms',
                content: 'We reserve the right to modify these terms at any time. We will post the updated terms on this page and update the "Last Updated" date. Your continued use of the website after changes indicates your acceptance of the updated terms.'
            },
            {
                title: '15. Contact Us',
                content: 'If you have any questions about these Terms of Use, please contact us through:\n\n• Email: info@rosacare.sy\n• Phone: +963-XXX-XXX-XXX\n• Address: Syria'
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

