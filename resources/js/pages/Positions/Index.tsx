import { Head, useForm, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { InputError } from '@/components/input-error';
import { useState, useEffect } from 'react';
import { Briefcase, FileText, User, Mail, Phone, Upload, X, CheckCircle, AlertCircle } from 'lucide-react';

interface Position {
    id: number;
    image?: string;
    image_url?: string;
    button_url?: string;
    button_color?: string;
    button_text_color?: string;
    name: string;
    description: string;
    qualifications: string;
    responsibilities: string;
    button_text?: string;
}

interface PositionsProps {
    positions: Position[];
    locale?: string;
}

export default function Positions({ positions = [], locale = 'ar' }: PositionsProps) {
    const isRTL = locale === 'ar';
    const page = usePage<any>();
    const menuItems = page.props.menuItems || [];
    const flashSuccess = page.props.flash?.success;
    const [selectedPosition, setSelectedPosition] = useState<Position | null>(null);
    const [showApplicationForm, setShowApplicationForm] = useState(false);
    const [cvFileName, setCvFileName] = useState<string>('');
    const [emailVerified, setEmailVerified] = useState(false);
    const [verificationCode, setVerificationCode] = useState('');
    const [verificationCodeSent, setVerificationCodeSent] = useState(false);
    const [resendCooldown, setResendCooldown] = useState(0);
    const [resendCount, setResendCount] = useState(0);
    const [captchaAnswer, setCaptchaAnswer] = useState('');
    const [captchaQuestion, setCaptchaQuestion] = useState({ num1: 0, num2: 0, answer: 0 });
    const [showPopup, setShowPopup] = useState(false);
    const [popupMessage, setPopupMessage] = useState('');
    const [popupType, setPopupType] = useState<'success' | 'error' | 'info'>('info');

    const { data, setData, post, processing, errors, reset, recentlySuccessful } = useForm({
        position_id: 0,
        name: '',
        email: '',
        phone: '',
        experience: '',
        qualifications: '',
        cv: null as File | null,
    });

    const { data: verificationData, setData: setVerificationData, post: postVerification, processing: verifyingCode, errors: verificationErrors, reset: resetVerification } = useForm({
        email: '',
        code: '',
    });

    // Generate captcha question
    const generateCaptcha = () => {
        const num1 = Math.floor(Math.random() * 10) + 1;
        const num2 = Math.floor(Math.random() * 10) + 1;
        setCaptchaQuestion({ num1, num2, answer: num1 + num2 });
        setCaptchaAnswer('');
    };

    // Show popup message
    const showPopupMessage = (message: string, type: 'success' | 'error' | 'info' = 'info') => {
        setPopupMessage(message);
        setPopupType(type);
        setShowPopup(true);
        setTimeout(() => {
            setShowPopup(false);
        }, 5000);
    };

    // Resend cooldown timer
    useEffect(() => {
        if (resendCooldown > 0) {
            const timer = setTimeout(() => {
                setResendCooldown(resendCooldown - 1);
            }, 1000);
            return () => clearTimeout(timer);
        }
    }, [resendCooldown]);

    // Generate captcha on mount and when form opens
    useEffect(() => {
        if (showApplicationForm) {
            generateCaptcha();
        }
    }, [showApplicationForm]);

    const handlePositionSelect = (position: Position) => {
        setSelectedPosition(position);
        setShowApplicationForm(true);
        setEmailVerified(false);
        setVerificationCodeSent(false);
        setVerificationCode('');
        setResendCooldown(0);
        setResendCount(0);
        reset();
        resetVerification();
        // Set position_id after reset to ensure it's not reset to 0
        setData('position_id', position.id);
        setCvFileName('');
        generateCaptcha();
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            setData('cv', file);
            setCvFileName(file.name);
        }
    };

    const sendVerificationCode = (e: React.FormEvent) => {
        e.preventDefault();

        // Debug: Log form data before submission
        console.log('Submitting form data:', {
            position_id: data.position_id,
            name: data.name,
            email: data.email,
            phone: data.phone,
            experience: data.experience,
            qualifications: data.qualifications,
            cv: data.cv ? data.cv.name : 'No file',
        });

        // Validate required fields before submission
        if (!data.position_id || data.position_id === 0) {
            console.error('Position ID is missing or invalid');
            showPopupMessage(locale === 'ar' ? 'يرجى اختيار وظيفة.' : 'Please select a position.', 'error');
            return;
        }

        if (!data.cv) {
            console.error('CV file is missing');
            showPopupMessage(locale === 'ar' ? 'يرجى رفع ملف السيرة الذاتية.' : 'Please upload your CV.', 'error');
            return;
        }

        // Validate captcha
        if (parseInt(captchaAnswer) !== captchaQuestion.answer) {
            showPopupMessage(locale === 'ar' ? 'إجابة التحقق غير صحيحة. يرجى المحاولة مرة أخرى.' : 'Invalid captcha answer. Please try again.', 'error');
            generateCaptcha();
            return;
        }

        // Submit form data to send verification code
        // Inertia automatically uses FormData when it detects File objects
        post('/position-applications/send-verification', {
            onSuccess: (page) => {
                setVerificationCodeSent(true);
                setResendCooldown(30);
                const message = page.props.flash?.verification_sent || (locale === 'ar' 
                    ? 'تم إرسال رمز التحقق إلى بريدك الإلكتروني.'
                    : 'Verification code has been sent to your email.');
                showPopupMessage(message, 'success');
            },
            onError: (errors) => {
                console.error('Form submission errors:', errors);
                // Log detailed error information
                if (errors) {
                    Object.keys(errors).forEach((key) => {
                        console.error(`Error in ${key}:`, errors[key]);
                        const errorMsg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
                        showPopupMessage(errorMsg, 'error');
                    });
                }
            },
            onFinish: () => {
                // This runs whether success or error
            },
        });
    };

    const resendVerificationCode = () => {
        if (resendCooldown > 0 || resendCount >= 3) {
            return;
        }

        const { post: postResend } = useForm({
            email: data.email,
            position_id: data.position_id,
        });

        postResend('/position-applications/resend-verification', {
            onSuccess: (page) => {
                setResendCount(resendCount + 1);
                setResendCooldown(30);
                const message = page.props.flash?.verification_resent || (locale === 'ar'
                    ? 'تم إعادة إرسال رمز التحقق.'
                    : 'Verification code has been resent.');
                showPopupMessage(message, 'success');
            },
            onError: (errors) => {
                if (errors) {
                    Object.keys(errors).forEach((key) => {
                        const errorMsg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
                        showPopupMessage(errorMsg, 'error');
                    });
                }
            },
        });
    };

    const verifyCode = (e: React.FormEvent) => {
        e.preventDefault();
        setVerificationData('email', data.email);
        setVerificationData('code', verificationCode);
        postVerification('/position-applications/verify-code', {
            onSuccess: (page) => {
                const message = page.props.flash?.success || (locale === 'ar'
                    ? 'تم التحقق بنجاح! تم إرسال طلبك.'
                    : 'Verification successful! Your application has been submitted.');
                showPopupMessage(message, 'success');
                setTimeout(() => {
                    reset();
                    setCvFileName('');
                    setShowApplicationForm(false);
                    setSelectedPosition(null);
                    setEmailVerified(false);
                    setVerificationCodeSent(false);
                    setVerificationCode('');
                    setResendCooldown(0);
                    setResendCount(0);
                }, 2000);
            },
            onError: (errors) => {
                if (errors) {
                    Object.keys(errors).forEach((key) => {
                        const errorMsg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
                        showPopupMessage(errorMsg, 'error');
                    });
                }
            },
        });
    };

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        // Submit form to send verification code
        sendVerificationCode(e);
    };

    const closeForm = () => {
        setShowApplicationForm(false);
        setSelectedPosition(null);
        reset();
        setCvFileName('');
        setEmailVerified(false);
        setVerificationCodeSent(false);
        setVerificationCode('');
    };

    return (
        <>
            <Head title={locale === 'ar' ? 'الوظائف المتاحة - روزاكير' : 'Career Opportunities - RosaCare'} />
            
            {/* Popup Message */}
            {showPopup && (
                <div className="fixed top-4 right-4 z-50 max-w-md animate-fade-in">
                    <div className={`rounded-lg shadow-lg p-4 flex items-start gap-3 ${
                        popupType === 'success' ? 'bg-green-50 border border-green-200' :
                        popupType === 'error' ? 'bg-red-50 border border-red-200' :
                        'bg-blue-50 border border-blue-200'
                    }`}>
                        {popupType === 'success' ? (
                            <CheckCircle className="h-5 w-5 text-green-600 flex-shrink-0 mt-0.5" />
                        ) : popupType === 'error' ? (
                            <AlertCircle className="h-5 w-5 text-red-600 flex-shrink-0 mt-0.5" />
                        ) : (
                            <CheckCircle className="h-5 w-5 text-blue-600 flex-shrink-0 mt-0.5" />
                        )}
                        <div className="flex-1">
                            <p className={`text-sm ${
                                popupType === 'success' ? 'text-green-800' :
                                popupType === 'error' ? 'text-red-800' :
                                'text-blue-800'
                            }`}>
                                {popupMessage}
                            </p>
                        </div>
                        <button
                            onClick={() => setShowPopup(false)}
                            className="text-gray-400 hover:text-gray-600"
                        >
                            <X className="h-4 w-4" />
                        </button>
                    </div>
                </div>
            )}

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
                    animation: fadeInUp 0.6s ease-out both;
                }
            `}</style>
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <Navbar menuItems={menuItems} locale={locale} />

                {/* Hero Section */}
                <section className="relative py-20" style={{
                    background: 'linear-gradient(135deg, rgba(231, 33, 119, 0.1) 0%, rgba(134, 44, 145, 0.1) 100%)',
                }}>
                    <div className="container mx-auto px-4 text-center">
                        <Briefcase className="h-16 w-16 mx-auto mb-6" style={{ color: '#e72177' }} />
                        <h1 className="text-4xl md:text-5xl font-light mb-4" style={{
                            fontFamily: "'Alexandria', sans-serif",
                            color: '#545759',
                            letterSpacing: '0.05em',
                        }}>
                            {locale === 'ar' ? 'الوظائف المتاحة' : 'Career Opportunities'}
                        </h1>
                        <p className="text-lg md:text-xl max-w-2xl mx-auto" style={{
                            fontFamily: "'Alexandria', sans-serif",
                            fontWeight: 300,
                            color: '#545759',
                        }}>
                            {locale === 'ar'
                                ? 'انضم إلى فريق روزاكير وكن جزءاً من رحلتنا في تقديم أفضل منتجات الورد الدمشقي الأصيل'
                                : 'Join the RosaCare team and be part of our journey in delivering the finest authentic Damask Rose products'}
                        </p>
                    </div>
                </section>

                {/* Positions List */}
                <section className="py-16 bg-white">
                    <div className="container mx-auto px-4">
                        {positions.length === 0 ? (
                            <div className="text-center py-20">
                                <p className="text-xl" style={{
                                    fontFamily: "'Alexandria', sans-serif",
                                    color: '#545759',
                                }}>
                                    {locale === 'ar' ? 'لا توجد وظائف متاحة حالياً' : 'No positions available at the moment'}
                                </p>
                            </div>
                        ) : (
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                                {positions.map((position, index) => (
                                    <div
                                        key={position.id}
                                        className="fade-in-up bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300"
                                        style={{
                                            animationDelay: `${index * 0.1}s`,
                                            border: '1px solid #e5e7eb',
                                        }}
                                    >
                                        {position.image_url && (
                                            <div className="relative h-48 overflow-hidden">
                                                <img
                                                    src={position.image_url}
                                                    alt={position.name}
                                                    className="w-full h-full object-cover"
                                                />
                                                <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent" />
                                            </div>
                                        )}
                                        <div className="p-6">
                                            <h3 className="text-2xl font-semibold mb-3" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                color: '#545759',
                                            }}>
                                                {position.name}
                                            </h3>
                                            <p className="text-sm mb-4 line-clamp-3" style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 300,
                                                color: '#6b7280',
                                                lineHeight: '1.6',
                                            }}>
                                                {position.description}
                                            </p>
                                            <button
                                                onClick={() => handlePositionSelect(position)}
                                                className="w-full py-3 px-6 rounded-lg text-white font-medium transition-all hover:-translate-y-0.5"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 500,
                                                    letterSpacing: '0.05em',
                                                    backgroundColor: position.button_color || '#e72177',
                                                    color: position.button_text_color || '#FFFFFF',
                                                    boxShadow: '0 5px 15px rgba(231, 33, 119, 0.3)',
                                                }}
                                                onMouseEnter={(e) => {
                                                    e.currentTarget.style.boxShadow = '0 8px 25px rgba(231, 33, 119, 0.4)';
                                                }}
                                                onMouseLeave={(e) => {
                                                    e.currentTarget.style.boxShadow = '0 5px 15px rgba(231, 33, 119, 0.3)';
                                                }}
                                            >
                                                {position.button_text || (locale === 'ar' ? 'تقديم طلب' : 'Apply Now')}
                                            </button>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                </section>

                {/* Application Form Modal */}
                {showApplicationForm && selectedPosition && (
                    <div className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                        <div className="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto" style={{
                            fontFamily: "'Alexandria', sans-serif",
                        }}>
                            {/* Modal Header */}
                            <div className="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between z-10">
                                <h2 className="text-2xl font-semibold" style={{ color: '#545759' }}>
                                    {locale === 'ar' ? 'تقديم طلب للوظيفة' : 'Apply for Position'}
                                </h2>
                                <button
                                    onClick={closeForm}
                                    className="p-2 rounded-full hover:bg-gray-100 transition-colors"
                                    aria-label={locale === 'ar' ? 'إغلاق' : 'Close'}
                                >
                                    <X className="h-6 w-6" style={{ color: '#545759' }} />
                                </button>
                            </div>

                            {/* Position Details */}
                            <div className="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <h3 className="text-xl font-semibold mb-2" style={{ color: '#545759' }}>
                                    {selectedPosition.name}
                                </h3>
                                <div className="space-y-4 text-sm" style={{ color: '#6b7280' }}>
                                    <div>
                                        <strong className="text-[#e72177]">{locale === 'ar' ? 'الوصف:' : 'Description:'}</strong>
                                        <p className="mt-1 whitespace-pre-wrap">{selectedPosition.description}</p>
                                    </div>
                                    <div>
                                        <strong className="text-[#e72177]">{locale === 'ar' ? 'المؤهلات المطلوبة:' : 'Required Qualifications:'}</strong>
                                        <p className="mt-1 whitespace-pre-wrap">{selectedPosition.qualifications}</p>
                                    </div>
                                    <div>
                                        <strong className="text-[#e72177]">{locale === 'ar' ? 'المسؤوليات:' : 'Responsibilities:'}</strong>
                                        <p className="mt-1 whitespace-pre-wrap">{selectedPosition.responsibilities}</p>
                                    </div>
                                </div>
                            </div>

                            {/* Application Form - Show first */}
                            {!verificationCodeSent && (
                                <form onSubmit={submit} className="p-6 space-y-6">
                                    {page.props.flash?.verification_sent && (
                                        <div className="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center gap-3">
                                            <CheckCircle className="h-5 w-5 text-blue-600" />
                                            <p className="text-blue-800">{page.props.flash.verification_sent}</p>
                                        </div>
                                    )}

                                    {/* Display general errors */}
                                    {Object.keys(errors).length > 0 && (
                                        <div className="bg-red-50 border border-red-200 rounded-lg p-4">
                                            <p className="text-red-800 font-semibold mb-2">
                                                {locale === 'ar' ? 'يرجى تصحيح الأخطاء التالية:' : 'Please correct the following errors:'}
                                            </p>
                                            <ul className="list-disc list-inside space-y-1">
                                                {Object.entries(errors).map(([key, value]) => (
                                                    <li key={key} className="text-red-700 text-sm">
                                                        {Array.isArray(value) ? value.join(', ') : value}
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                    )}

                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label htmlFor="name" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                                <User className="inline h-4 w-4 mr-2" />
                                                {locale === 'ar' ? 'الاسم الكامل *' : 'Full Name *'}
                                            </label>
                                            <input
                                                id="name"
                                                type="text"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                required
                                                disabled={verificationCodeSent}
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none disabled:bg-gray-50 disabled:cursor-not-allowed"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    borderColor: '#bdc4c8',
                                                }}
                                            />
                                            <InputError message={errors.name} className="mt-1" />
                                        </div>

                                        <div>
                                            <label htmlFor="email" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                                <Mail className="inline h-4 w-4 mr-2" />
                                                {locale === 'ar' ? 'البريد الإلكتروني *' : 'Email Address *'}
                                            </label>
                                            <input
                                                id="email"
                                                type="email"
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                required
                                                disabled={verificationCodeSent}
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none disabled:bg-gray-50 disabled:cursor-not-allowed"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    borderColor: '#bdc4c8',
                                                }}
                                            />
                                            <InputError message={errors.email} className="mt-1" />
                                        </div>
                                    </div>

                                    <div>
                                        <label htmlFor="phone" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                            <Phone className="inline h-4 w-4 mr-2" />
                                            {locale === 'ar' ? 'رقم الهاتف' : 'Phone Number'}
                                        </label>
                                        <input
                                            id="phone"
                                            type="tel"
                                            value={data.phone}
                                            onChange={(e) => setData('phone', e.target.value)}
                                            disabled={verificationCodeSent}
                                            className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none disabled:bg-gray-50 disabled:cursor-not-allowed"
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                borderColor: '#bdc4c8',
                                            }}
                                        />
                                        <InputError message={errors.phone} className="mt-1" />
                                    </div>

                                    <div>
                                        <label htmlFor="cv" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                            <Upload className="inline h-4 w-4 mr-2" />
                                            {locale === 'ar' ? 'السيرة الذاتية (PDF, DOC, DOCX) *' : 'CV (PDF, DOC, DOCX) *'}
                                        </label>
                                        <div className="relative">
                                            <input
                                                id="cv"
                                                type="file"
                                                accept=".pdf,.doc,.docx"
                                                onChange={handleFileChange}
                                                required
                                                disabled={verificationCodeSent}
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e72177] file:text-white file:cursor-pointer hover:file:bg-[#c91e66] disabled:bg-gray-50 disabled:cursor-not-allowed disabled:file:cursor-not-allowed"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    borderColor: '#bdc4c8',
                                                }}
                                            />
                                            {cvFileName && (
                                                <p className="mt-2 text-sm text-gray-600 flex items-center gap-2">
                                                    <FileText className="h-4 w-4" />
                                                    {cvFileName}
                                                </p>
                                            )}
                                        </div>
                                        <InputError message={errors.cv} className="mt-1" />
                                        <p className="mt-1 text-xs text-gray-500">
                                            {locale === 'ar' ? 'الحد الأقصى لحجم الملف: 10 ميجابايت' : 'Maximum file size: 10MB'}
                                        </p>
                                    </div>

                                    <div>
                                        <label htmlFor="experience" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                            {locale === 'ar' ? 'الخبرة *' : 'Experience *'}
                                        </label>
                                    <textarea
                                        id="experience"
                                        value={data.experience}
                                        onChange={(e) => setData('experience', e.target.value)}
                                        required
                                        rows={5}
                                        disabled={verificationCodeSent}
                                        className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none resize-y disabled:bg-gray-50 disabled:cursor-not-allowed"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            borderColor: '#bdc4c8',
                                        }}
                                        placeholder={locale === 'ar' ? 'يرجى وصف خبرتك المهنية...' : 'Please describe your professional experience...'}
                                    />
                                        <InputError message={errors.experience} className="mt-1" />
                                    </div>

                                    <div>
                                        <label htmlFor="qualifications" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                            {locale === 'ar' ? 'المؤهلات *' : 'Qualifications *'}
                                        </label>
                                    <textarea
                                        id="qualifications"
                                        value={data.qualifications}
                                        onChange={(e) => setData('qualifications', e.target.value)}
                                        required
                                        rows={5}
                                        disabled={verificationCodeSent}
                                        className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none resize-y disabled:bg-gray-50 disabled:cursor-not-allowed"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            borderColor: '#bdc4c8',
                                        }}
                                        placeholder={locale === 'ar' ? 'يرجى ذكر مؤهلاتك التعليمية والشهادات...' : 'Please list your educational qualifications and certifications...'}
                                    />
                                        <InputError message={errors.qualifications} className="mt-1" />
                                    </div>

                                    {/* Captcha */}
                                    <div className="bg-gray-50 p-4 rounded-lg border-2" style={{ borderColor: '#bdc4c8' }}>
                                        <label className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                            {locale === 'ar' ? 'التحقق من أنك لست روبوت:' : 'Verify you are not a robot:'}
                                        </label>
                                        <div className="flex items-center gap-4">
                                            <div className="flex items-center gap-2 text-lg font-semibold" style={{ color: '#545759' }}>
                                                <span>{captchaQuestion.num1}</span>
                                                <span>+</span>
                                                <span>{captchaQuestion.num2}</span>
                                                <span>=</span>
                                            </div>
                                            <input
                                                type="number"
                                                value={captchaAnswer}
                                                onChange={(e) => setCaptchaAnswer(e.target.value)}
                                                className="w-20 px-3 py-2 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    borderColor: '#bdc4c8',
                                                }}
                                                placeholder="?"
                                                required
                                            />
                                            <button
                                                type="button"
                                                onClick={generateCaptcha}
                                                className="text-sm text-[#e72177] hover:underline"
                                            >
                                                {locale === 'ar' ? 'تحديث' : 'Refresh'}
                                            </button>
                                        </div>
                                    </div>

                                    <div className="flex gap-4 pt-4">
                                        <button
                                            type="submit"
                                            disabled={processing || !data.cv || parseInt(captchaAnswer) !== captchaQuestion.answer}
                                            className="flex-1 py-3 px-6 rounded-lg text-white font-medium transition-all hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none"
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                fontWeight: 500,
                                                letterSpacing: '0.05em',
                                                background: 'linear-gradient(135deg, #e72177, #862b90)',
                                                boxShadow: '0 5px 20px rgba(231, 33, 119, 0.3)',
                                            }}
                                        >
                                            {processing
                                                ? (locale === 'ar' ? 'جاري الإرسال...' : 'Sending...')
                                                : (locale === 'ar' ? 'إرسال رمز التحقق' : 'Send Verification Code')}
                                        </button>
                                        <button
                                            type="button"
                                            onClick={closeForm}
                                            className="px-6 py-3 rounded-lg border-2 font-medium transition-all hover:bg-gray-50"
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                borderColor: '#bdc4c8',
                                                color: '#545759',
                                            }}
                                        >
                                            {locale === 'ar' ? 'إلغاء' : 'Cancel'}
                                        </button>
                                    </div>
                                </form>
                            )}

                            {/* Email Verification Step - Show after form submission */}
                            {verificationCodeSent && (
                                <div className="p-6 space-y-6">
                                    {page.props.flash?.verification_sent && (
                                        <div className="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center gap-3">
                                            <CheckCircle className="h-5 w-5 text-blue-600" />
                                            <p className="text-blue-800">{page.props.flash.verification_sent}</p>
                                        </div>
                                    )}

                                    <div>
                                        <h3 className="text-xl font-semibold mb-4" style={{ color: '#545759' }}>
                                            {locale === 'ar' ? 'التحقق من البريد الإلكتروني' : 'Email Verification'}
                                        </h3>
                                        <div className="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                            <p className="text-sm" style={{ color: '#6b7280' }}>
                                                {locale === 'ar'
                                                    ? `تم إرسال رمز التحقق إلى بريدك الإلكتروني: ${data.email}`
                                                    : `A verification code has been sent to your email: ${data.email}`}
                                            </p>
                                            <p className="text-xs mt-2" style={{ color: '#6b7280' }}>
                                                {locale === 'ar'
                                                    ? 'يرجى إدخال الرمز لإكمال تقديم طلبك.'
                                                    : 'Please enter the code to complete your application.'}
                                            </p>
                                        </div>
                                    </div>

                                    {/* Resend Verification Code Button */}
                                    <div className="flex items-center justify-between bg-gray-50 p-4 rounded-lg mb-4">
                                        <button
                                            type="button"
                                            onClick={resendVerificationCode}
                                            disabled={resendCooldown > 0 || resendCount >= 3}
                                            className="text-sm text-[#e72177] hover:underline disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            {resendCooldown > 0
                                                ? (locale === 'ar' ? `إعادة الإرسال بعد ${resendCooldown} ثانية` : `Resend in ${resendCooldown}s`)
                                                : resendCount >= 3
                                                ? (locale === 'ar' ? 'تم تجاوز الحد الأقصى للمحاولات' : 'Maximum attempts reached')
                                                : (locale === 'ar' ? 'إعادة إرسال رمز التحقق' : 'Resend Verification Code')}
                                        </button>
                                        {resendCount > 0 && (
                                            <span className="text-sm text-gray-500">
                                                {locale === 'ar' ? `محاولات إعادة الإرسال: ${resendCount}/3` : `Resend attempts: ${resendCount}/3`}
                                            </span>
                                        )}
                                    </div>

                                    <form onSubmit={verifyCode} className="space-y-4">
                                        <div>
                                            <label htmlFor="verification-code" className="block mb-2 font-medium" style={{ color: '#545759' }}>
                                                {locale === 'ar' ? 'رمز التحقق *' : 'Verification Code *'}
                                            </label>
                                            <input
                                                id="verification-code"
                                                type="text"
                                                value={verificationCode}
                                                onChange={(e) => {
                                                    const value = e.target.value.replace(/\D/g, '').slice(0, 6);
                                                    setVerificationCode(value);
                                                    setVerificationData('code', value);
                                                }}
                                                required
                                                maxLength={6}
                                                placeholder={locale === 'ar' ? 'أدخل الرمز المكون من 6 أرقام' : 'Enter 6-digit code'}
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none text-center text-2xl tracking-widest"
                                                style={{
                                                    fontFamily: "'Courier New', monospace",
                                                    borderColor: '#bdc4c8',
                                                    letterSpacing: '0.5em',
                                                }}
                                            />
                                            <InputError message={verificationErrors.code} className="mt-1" />
                                            <p className="mt-2 text-xs text-gray-500">
                                                {locale === 'ar'
                                                    ? 'أدخل الرمز المكون من 6 أرقام الذي تم إرساله إلى بريدك الإلكتروني'
                                                    : 'Enter the 6-digit code sent to your email'}
                                            </p>
                                        </div>
                                        <div className="flex gap-4">
                                            <button
                                                type="submit"
                                                disabled={verifyingCode || verificationCode.length !== 6}
                                                className="flex-1 py-3 px-6 rounded-lg text-white font-medium transition-all hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed disabled:transform-none"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    fontWeight: 500,
                                                    letterSpacing: '0.05em',
                                                    background: 'linear-gradient(135deg, #e72177, #862b90)',
                                                    boxShadow: '0 5px 20px rgba(231, 33, 119, 0.3)',
                                                }}
                                            >
                                                {verifyingCode
                                                    ? (locale === 'ar' ? 'جاري التحقق...' : 'Verifying...')
                                                    : (locale === 'ar' ? 'تحقق وإرسال الطلب' : 'Verify & Submit')}
                                            </button>
                                            <button
                                                type="button"
                                                onClick={() => {
                                                    setVerificationCodeSent(false);
                                                    setVerificationCode('');
                                                }}
                                                className="px-6 py-3 rounded-lg border-2 font-medium transition-all hover:bg-gray-50"
                                                style={{
                                                    fontFamily: "'Alexandria', sans-serif",
                                                    borderColor: '#bdc4c8',
                                                    color: '#545759',
                                                }}
                                            >
                                                {locale === 'ar' ? 'تعديل البيانات' : 'Edit Information'}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            )}
                        </div>
                    </div>
                )}

                <Footer locale={locale} />
            </div>
        </>
    );
}

