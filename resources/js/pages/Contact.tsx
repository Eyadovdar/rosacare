import { Head, useForm, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { Collapsible, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible';
import { InputError } from '@/components/input-error';
import { ChevronDown, Mail, Phone, MapPin, Facebook, Twitter, Instagram, Linkedin, Youtube } from 'lucide-react';
import { useState } from 'react';

interface Faq {
    id: number;
    question: string;
    answer: string;
}

interface ContactInfo {
    email?: string;
    phone?: string;
    address?: string;
    googleMapIframe?: string;
    facebook?: string;
    twitter?: string;
    instagram?: string;
    linkedin?: string;
    youtube?: string;
    tiktok?: string;
}

interface ContactProps {
    locale?: string;
    faqs?: Faq[];
    contactInfo?: ContactInfo;
}

export default function Contact({ locale = 'ar', faqs = [], contactInfo = {} }: ContactProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const [openFaqs, setOpenFaqs] = useState<Record<number, boolean>>({});
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        phone: '',
        subject: '',
        message: '',
    });

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/contact', {
            onSuccess: () => reset(),
        });
    };

    const toggleFaq = (id: number) => {
        setOpenFaqs(prev => ({
            ...prev,
            [id]: !prev[id]
        }));
    };

    return (
        <>
            <Head title={locale === 'ar' ? 'اتصل بنا - روزاكير' : 'Contact Us - RosaCare'} />
            <style>{`
                @keyframes fadeIn {
                    from { opacity: 0; }
                    to { opacity: 1; }
                }
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
                @keyframes float {
                    0%, 100% {
                        transform: translate(0, 0) rotate(0deg);
                    }
                    33% {
                        transform: translate(30px, -30px) rotate(120deg);
                    }
                    66% {
                        transform: translate(-30px, 30px) rotate(240deg);
                    }
                }
                .rose-petals {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    pointer-events: none;
                    z-index: 1;
                    overflow: hidden;
                }
                .rose-petals::before,
                .rose-petals::after {
                    content: '';
                    position: absolute;
                    width: 250px;
                    height: 250px;
                    border-radius: 50% 0 50% 0;
                    background: linear-gradient(135deg, rgba(231, 33, 119, 0.08), rgba(134, 44, 145, 0.08));
                    animation: float 20s infinite ease-in-out;
                }
                .rose-petals::before {
                    top: 20%;
                    left: 5%;
                    animation-delay: 0s;
                }
                .rose-petals::after {
                    top: 50%;
                    right: 5%;
                    animation-delay: 10s;
                }
                .contact-content {
                    position: relative;
                    z-index: 2;
                }
                .fade-in-up {
                    animation: fadeInUp 1s ease-out both;
                }
                .fade-in {
                    animation: fadeIn 1s ease-out both;
                }
            `}</style>
            <div className={`min-h-screen relative ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                {/* Animated Rose Petals Background */}
                <div className="rose-petals" />

                <Navbar menuItems={menuItems} locale={locale} />
                <section className="py-20 relative" style={{
                    background: 'linear-gradient(135deg, #f5f5f5 0%, #ffffff 50%, #fafafa 100%)',
                    minHeight: 'calc(100vh - 4rem)'
                }}>
                    <div className="container mx-auto px-4 max-w-7xl contact-content">
                        {/* Header */}
                        <div className="text-center mb-16 fade-in-up" style={{ animationDelay: '0.3s' }}>
                            <h1 className={`text-4xl md:text-5xl font-light mb-4 ${isRTL ? 'rtl' : 'ltr'}`} style={{
                                fontFamily: "'Alexandria', sans-serif",
                                color: '#545759',
                                letterSpacing: '0.1em'
                            }}>
                                {locale === 'ar' ? 'اتصل بنا' : 'Contact Us'}
                            </h1>
                            <p className="text-lg max-w-2xl mx-auto fade-in-up" style={{
                                fontFamily: "'Alexandria', sans-serif",
                                color: '#862b90',
                                fontStyle: 'italic',
                                animationDelay: '0.5s'
                            }}>
                                {locale === 'ar'
                                    ? 'نحن هنا للإجابة على جميع استفساراتك ومساعدتك في أي وقت'
                                    : 'We\'re here to answer all your questions and help you anytime'}
                            </p>
                        </div>

                        {/* Contact Form - Full Width */}
                        <div className="mb-12 fade-in-up" style={{ animationDelay: '0.7s' }}>
                            <div className="max-w-4xl mx-auto" style={{
                                padding: '3rem 2rem',
                                background: 'rgba(255, 255, 255, 0.8)',
                                borderRadius: '20px',
                                boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                            }}>
                                    <h2 className="text-2xl md:text-2.5xl font-normal mb-2 text-center" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#545759',
                                        letterSpacing: '0.05em'
                                    }}>
                                        {locale === 'ar' ? 'أرسل لنا رسالة' : 'Send us a message'}
                                    </h2>
                                    <p className="text-base font-light mb-6 text-center" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#545759',
                                        opacity: 0.8
                                    }}>
                                        {locale === 'ar'
                                            ? 'املأ النموذج أدناه وسنعود إليك في أقرب وقت ممكن'
                                            : 'Fill out the form below and we\'ll get back to you as soon as possible'}
                                    </p>

                                    <form onSubmit={submit} className="space-y-4">
                                        <div>
                                            <input
                                                id="name"
                                                type="text"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                placeholder={locale === 'ar' ? 'الاسم الكامل *' : 'Your Name *'}
                                                required
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    fontSize: '1rem',
                                                    color: '#545759',
                                                    background: '#ffffff',
                                                    borderColor: '#bdc4c8'
                                                }}
                                            />
                                            <InputError message={errors.name} className="mt-1" />
                                        </div>

                                        <div>
                                            <input
                                                id="email"
                                                type="email"
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                placeholder={locale === 'ar' ? 'البريد الإلكتروني *' : 'Your Email *'}
                                                required
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    fontSize: '1rem',
                                                    color: '#545759',
                                                    background: '#ffffff',
                                                    borderColor: '#bdc4c8'
                                                }}
                                            />
                                            <InputError message={errors.email} className="mt-1" />
                                        </div>

                                        <div>
                                            <input
                                                id="phone"
                                                type="tel"
                                                value={data.phone}
                                                onChange={(e) => setData('phone', e.target.value)}
                                                placeholder={locale === 'ar' ? 'رقم الهاتف' : 'Phone Number'}
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    fontSize: '1rem',
                                                    color: '#545759',
                                                    background: '#ffffff',
                                                    borderColor: '#bdc4c8'
                                                }}
                                            />
                                            <InputError message={errors.phone} className="mt-1" />
                                        </div>

                                        <div>
                                            <input
                                                id="subject"
                                                type="text"
                                                value={data.subject}
                                                onChange={(e) => setData('subject', e.target.value)}
                                                placeholder={locale === 'ar' ? 'الموضوع' : 'Subject'}
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    fontSize: '1rem',
                                                    color: '#545759',
                                                    background: '#ffffff',
                                                    borderColor: '#bdc4c8'
                                                }}
                                            />
                                            <InputError message={errors.subject} className="mt-1" />
                                        </div>

                                        <div>
                                            <textarea
                                                id="message"
                                                value={data.message}
                                                onChange={(e) => setData('message', e.target.value)}
                                                rows={5}
                                                placeholder={locale === 'ar' ? 'الرسالة *' : 'Your Message *'}
                                                required
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none resize-y min-h-[120px]"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 300,
                                                    fontSize: '1rem',
                                                    color: '#545759',
                                                    background: '#ffffff',
                                                    borderColor: '#bdc4c8'
                                                }}
                                            />
                                            <InputError message={errors.message} className="mt-1" />
                                        </div>

                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="w-full py-3 px-6 rounded-lg text-white font-medium text-lg transition-all hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none"
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 500,
                                                letterSpacing: '0.05em',
                                                background: 'linear-gradient(135deg, #e72177, #862b90)',
                                                boxShadow: processing ? '0 5px 20px rgba(231, 33, 119, 0.3)' : '0 5px 20px rgba(231, 33, 119, 0.3)'
                                            }}
                                            onMouseEnter={(e) => {
                                                if (!processing) {
                                                    e.currentTarget.style.boxShadow = '0 8px 30px rgba(231, 33, 119, 0.4)';
                                                }
                                            }}
                                            onMouseLeave={(e) => {
                                                e.currentTarget.style.boxShadow = '0 5px 20px rgba(231, 33, 119, 0.3)';
                                            }}
                                        >
                                            {processing
                                                ? (locale === 'ar' ? 'جاري الإرسال...' : 'Sending...')
                                                : (locale === 'ar' ? 'إرسال الرسالة' : 'Send Message')}
                                        </button>
                                    </form>
                                </div>
                            </div>

                        {/* Contact Information & Map - Full Width, 50/50 Split */}
                        {(contactInfo.email || contactInfo.phone || contactInfo.address || contactInfo.googleMapIframe) && (
                            <div className="mb-12 fade-in-up" style={{ animationDelay: '0.9s' }}>
                                <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    {/* Contact Information - 50% */}
                                    {(contactInfo.email || contactInfo.phone || contactInfo.address) && (
                                        <div style={{
                                            padding: '2rem 1.5rem',
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            borderRadius: '20px',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <h3 className="text-xl font-normal mb-6" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                color: '#545759'
                                            }}>
                                                {locale === 'ar' ? 'معلومات الاتصال' : 'Contact Information'}
                                            </h3>
                                            <div className="space-y-5">
                                                {contactInfo.email && (
                                                <div className="flex items-start gap-3">
                                                    <Mail className="h-5 w-5 flex-shrink-0 mt-0.5" style={{ color: '#e72177' }} />
                                                    <div className="flex-1">
                                                        <p className="text-sm font-medium mb-1" style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            color: '#545759',
                                                            opacity: 0.8
                                                        }}>
                                                            {locale === 'ar' ? 'البريد الإلكتروني' : 'Email'}
                                                        </p>
                                                        <a
                                                            href={`mailto:${contactInfo.email}`}
                                                            className="text-sm hover:underline"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                color: '#e72177'
                                                            }}
                                                        >
                                                            {contactInfo.email}
                                                        </a>
                                                    </div>
                                                </div>
                                            )}
                                            {contactInfo.phone && (
                                                <div className="flex items-start gap-3">
                                                    <Phone className="h-5 w-5 flex-shrink-0 mt-0.5" style={{ color: '#e72177' }} />
                                                    <div className="flex-1">
                                                        <p className="text-sm font-medium mb-1" style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            color: '#545759',
                                                            opacity: 0.8
                                                        }}>
                                                            {locale === 'ar' ? 'الهاتف' : 'Phone'}
                                                        </p>
                                                        <a
                                                            href={`tel:${contactInfo.phone}`}
                                                            className="text-sm hover:underline"
                                                            style={{
                                                                fontFamily: "'Alexandria', sans-serif",
                                                                color: '#e72177'
                                                            }}
                                                        >
                                                            {contactInfo.phone}
                                                        </a>
                                                    </div>
                                                </div>
                                            )}
                                            {contactInfo.address && (
                                                <div className="flex items-start gap-3">
                                                    <MapPin className="h-5 w-5 flex-shrink-0 mt-0.5" style={{ color: '#e72177' }} />
                                                    <div className="flex-1">
                                                        <p className="text-sm font-medium mb-1" style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            color: '#545759',
                                                            opacity: 0.8
                                                        }}>
                                                            {locale === 'ar' ? 'العنوان' : 'Address'}
                                                        </p>
                                                        <p className="text-sm" style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            color: '#545759'
                                                        }}>
                                                            {contactInfo.address}
                                                        </p>
                                                    </div>
                                                </div>
                                            )}

                                            {/* Social Media Links */}
                                            {(contactInfo.facebook || contactInfo.twitter || contactInfo.instagram || contactInfo.linkedin || contactInfo.youtube || contactInfo.tiktok) && (
                                                <div className="pt-4 border-t" style={{ borderColor: '#bdc4c8' }}>
                                                    <p className="text-sm font-medium mb-3" style={{
                                                        fontFamily: "'Alexandria', sans-serif",
                                                        color: '#545759',
                                                        opacity: 0.8
                                                    }}>
                                                        {locale === 'ar' ? 'تابعنا على' : 'Follow Us'}
                                                    </p>
                                                    <div className="flex flex-wrap gap-3">
                                                        {contactInfo.facebook && (
                                                            <a
                                                                href={contactInfo.facebook}
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                className="h-9 w-9 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                                                style={{
                                                                    background: 'rgba(231, 33, 119, 0.1)'
                                                                }}
                                                                aria-label="Facebook"
                                                            >
                                                                <Facebook className="h-4 w-4" style={{ color: '#e72177' }} />
                                                            </a>
                                                        )}
                                                        {contactInfo.twitter && (
                                                            <a
                                                                href={contactInfo.twitter}
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                className="h-9 w-9 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                                                style={{
                                                                    background: 'rgba(231, 33, 119, 0.1)'
                                                                }}
                                                                aria-label="Twitter"
                                                            >
                                                                <Twitter className="h-4 w-4" style={{ color: '#e72177' }} />
                                                            </a>
                                                        )}
                                                        {contactInfo.instagram && (
                                                            <a
                                                                href={contactInfo.instagram}
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                className="h-9 w-9 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                                                style={{
                                                                    background: 'rgba(231, 33, 119, 0.1)'
                                                                }}
                                                                aria-label="Instagram"
                                                            >
                                                                <Instagram className="h-4 w-4" style={{ color: '#e72177' }} />
                                                            </a>
                                                        )}
                                                        {contactInfo.linkedin && (
                                                            <a
                                                                href={contactInfo.linkedin}
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                className="h-9 w-9 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                                                style={{
                                                                    background: 'rgba(231, 33, 119, 0.1)'
                                                                }}
                                                                aria-label="LinkedIn"
                                                            >
                                                                <Linkedin className="h-4 w-4" style={{ color: '#e72177' }} />
                                                            </a>
                                                        )}
                                                        {contactInfo.youtube && (
                                                            <a
                                                                href={contactInfo.youtube}
                                                                target="_blank"
                                                                rel="noopener noreferrer"
                                                                className="h-9 w-9 rounded-full flex items-center justify-center transition-all hover:scale-110"
                                                                style={{
                                                                    background: 'rgba(231, 33, 119, 0.1)'
                                                                }}
                                                                aria-label="YouTube"
                                                            >
                                                                <Youtube className="h-4 w-4" style={{ color: '#e72177' }} />
                                                            </a>
                                                        )}
                                                    </div>
                                                </div>
                                                )}
                                            </div>
                                        </div>
                                    )}

                                    {/* Google Map - 50% */}
                                    {contactInfo.googleMapIframe && (
                                        <div style={{
                                            padding: '2rem 1.5rem',
                                            background: 'rgba(255, 255, 255, 0.8)',
                                            borderRadius: '20px',
                                            boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                        }}>
                                            <h3 className="text-xl font-normal mb-6" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                color: '#545759'
                                            }}>
                                                {locale === 'ar' ? 'موقعنا' : 'Our Location'}
                                            </h3>
                                            <div
                                                className="w-full rounded-lg overflow-hidden"
                                                style={{
                                                    minHeight: '400px',
                                                    border: '2px solid #bdc4c8'
                                                }}
                                                dangerouslySetInnerHTML={{ __html: contactInfo.googleMapIframe }}
                                            />
                                        </div>
                                    )}
                                </div>
                            </div>
                        )}

                        {/* FAQs Section - Full Width */}
                        {faqs.length > 0 && (
                            <div className="mt-16 fade-in-up" style={{ animationDelay: '1.1s' }}>
                                <div className="max-w-1200 mx-auto" style={{
                                    padding: '3rem 2rem',
                                    background: 'rgba(255, 255, 255, 0.8)',
                                    borderRadius: '20px',
                                    boxShadow: '0 10px 40px rgba(231, 33, 119, 0.1)'
                                }}>
                                    <h2 className="text-2xl md:text-2.5xl font-normal mb-2 text-center" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#545759',
                                        letterSpacing: '0.05em'
                                    }}>
                                        {locale === 'ar' ? 'الأسئلة الشائعة' : 'Frequently Asked Questions'}
                                    </h2>
                                    <p className="text-base font-light mb-6 text-center" style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        color: '#545759',
                                        opacity: 0.8
                                    }}>
                                        {locale === 'ar'
                                            ? 'إجابات على الأسئلة الأكثر شيوعاً'
                                            : 'Answers to the most commonly asked questions'}
                                    </p>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-5xl mx-auto">
                                            {faqs.map((faq) => (
                                                <Collapsible
                                                    key={faq.id}
                                                    open={openFaqs[faq.id] || false}
                                                    onOpenChange={() => toggleFaq(faq.id)}
                                                    className="rounded-lg transition-all"
                                                    style={{
                                                        border: '2px solid #bdc4c8',
                                                        background: '#ffffff'
                                                    }}
                                                    onMouseEnter={(e) => {
                                                        e.currentTarget.style.borderColor = '#e72177';
                                                    }}
                                                    onMouseLeave={(e) => {
                                                        if (!openFaqs[faq.id]) {
                                                            e.currentTarget.style.borderColor = '#bdc4c8';
                                                        }
                                                    }}
                                                >
                                                    <CollapsibleTrigger className="w-full flex items-center justify-between p-4 hover:bg-[#f5f5f5] transition-colors rounded-lg text-left">
                                                        <span className="font-medium text-base flex-1 pr-2" style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            color: '#545759'
                                                        }}>
                                                            {faq.question}
                                                        </span>
                                                        <ChevronDown
                                                            className={`h-5 w-5 transition-transform flex-shrink-0 ${openFaqs[faq.id] ? 'rotate-180' : ''}`}
                                                            style={{ color: '#e72177' }}
                                                        />
                                                    </CollapsibleTrigger>
                                                    <CollapsibleContent className="px-4 pb-4">
                                                        <p className="text-sm leading-relaxed" style={{
                                                            fontFamily: "'Alexandria', sans-serif",
                                                            fontWeight: 300,
                                                            color: '#545759',
                                                            opacity: 0.8
                                                        }}>
                                                            {faq.answer}
                                                        </p>
                                                    </CollapsibleContent>
                                                </Collapsible>
                                            ))}
                                        </div>
                                    </div>
                        </div>
                            )}
                    </div>
                </section>
                <Footer locale={locale} />
            </div>
        </>
    );
}
