import { Head, useForm, usePage } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Navbar } from '@/components/rosacare/Navbar';
import { InputError } from '@/components/input-error';
import { useState } from 'react';
import { Briefcase, FileText, User, Mail, Phone, Upload, X, CheckCircle } from 'lucide-react';

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
    const [selectedPosition, setSelectedPosition] = useState<Position | null>(null);
    const [showApplicationForm, setShowApplicationForm] = useState(false);
    const [cvFileName, setCvFileName] = useState<string>('');

    const { data, setData, post, processing, errors, reset, recentlySuccessful } = useForm({
        position_id: 0,
        name: '',
        email: '',
        phone: '',
        experience: '',
        qualifications: '',
        cv: null as File | null,
    });

    const handlePositionSelect = (position: Position) => {
        setSelectedPosition(position);
        setData('position_id', position.id);
        setShowApplicationForm(true);
        reset();
        setCvFileName('');
    };

    const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        const file = e.target.files?.[0];
        if (file) {
            setData('cv', file);
            setCvFileName(file.name);
        }
    };

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/position-applications', {
            forceFormData: true,
            onSuccess: () => {
                reset();
                setCvFileName('');
                setShowApplicationForm(false);
                setSelectedPosition(null);
            },
        });
    };

    const closeForm = () => {
        setShowApplicationForm(false);
        setSelectedPosition(null);
        reset();
        setCvFileName('');
    };

    return (
        <>
            <Head title={locale === 'ar' ? 'الوظائف المتاحة - روزاكير' : 'Career Opportunities - RosaCare'} />
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

                            {/* Application Form */}
                            <form onSubmit={submit} className="p-6 space-y-6">
                                {recentlySuccessful && (
                                    <div className="bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
                                        <CheckCircle className="h-5 w-5 text-green-600" />
                                        <p className="text-green-800">
                                            {locale === 'ar' 
                                                ? 'تم إرسال طلبك بنجاح! سنتواصل معك قريباً.' 
                                                : 'Your application has been submitted successfully! We will contact you soon.'}
                                        </p>
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
                                            className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
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
                                            className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
                                            style={{
                                                fontFamily: "'Alexandria', sans-serif",
                                                borderColor: '#bdc4c8',
                                            }}
                                        />
                                        <InputError message={errors.email} className="mt-1" />
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
                                            className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none"
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
                                                className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#e72177] file:text-white file:cursor-pointer hover:file:bg-[#c91e66]"
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
                                        className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none resize-y"
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
                                        className="w-full px-4 py-3 rounded-lg border-2 transition-all focus:border-[#e72177] focus:ring-4 focus:ring-[#e72177]/10 outline-none resize-y"
                                        style={{
                                            fontFamily: "'Alexandria', sans-serif",
                                            borderColor: '#bdc4c8',
                                        }}
                                        placeholder={locale === 'ar' ? 'يرجى ذكر مؤهلاتك التعليمية والشهادات...' : 'Please list your educational qualifications and certifications...'}
                                    />
                                    <InputError message={errors.qualifications} className="mt-1" />
                                </div>

                                <div className="flex gap-4 pt-4">
                                    <button
                                        type="submit"
                                        disabled={processing}
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
                                            ? (locale === 'ar' ? 'جاري الإرسال...' : 'Submitting...')
                                            : (locale === 'ar' ? 'إرسال الطلب' : 'Submit Application')}
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
                        </div>
                    </div>
                )}

                <Footer menuItems={menuItems} locale={locale} />
            </div>
        </>
    );
}

