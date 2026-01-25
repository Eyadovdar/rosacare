import { Briefcase } from 'lucide-react';
import { Link } from '@inertiajs/react';

interface Position {
    id: number;
    image?: string;
    image_url?: string;
    button_url?: string;
    button_color?: string;
    button_text_color?: string;
    name: string;
    description: string;
    button_text?: string;
}

interface PositionSectionProps {
    locale?: string;
    positions?: Position[];
}

export function PositionSection({ locale = 'ar', positions = [] }: PositionSectionProps) {
    const isRTL = locale === 'ar';

    if (!positions || positions.length === 0) {
        return null;
    }

    return (
        <section
            id="positions"
            className="py-20 relative"
            style={{
                background: 'linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%)'
            }}
        >
            <div className="container mx-auto px-4 relative" style={{ zIndex: 2 }}>
                <div className="text-center mb-12">
                    <Briefcase className="h-12 w-12 mx-auto mb-4" style={{ color: '#e72177' }} />
                    <h2 className={`text-4xl md:text-5xl font-light mb-4 ${isRTL ? 'rtl' : 'ltr'}`} style={{ 
                        fontFamily: "'Alexandria', sans-serif",
                        color: '#545759',
                        letterSpacing: '0.05em',
                    }}>
                        {locale === 'ar' ? 'الوظائف المتاحة' : 'Career Opportunities'}
                    </h2>
                    <p className="text-lg md:text-xl max-w-2xl mx-auto" style={{
                        fontFamily: "'Alexandria', sans-serif",
                        fontWeight: 300,
                        color: '#6b7280',
                    }}>
                        {locale === 'ar' 
                            ? 'انضم إلى فريق روزاكير وكن جزءاً من رحلتنا'
                            : 'Join the RosaCare team and be part of our journey'}
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    {positions.map((position, index) => (
                        <div
                            key={position.id}
                            className="fade-in-up bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300"
                            style={{
                                animationDelay: `${index * 0.1}s`,
                                border: '1px solid #e5e7eb',
                            }}
                            onMouseEnter={(e) => {
                                e.currentTarget.style.transform = 'translateY(-5px)';
                            }}
                            onMouseLeave={(e) => {
                                e.currentTarget.style.transform = 'translateY(0)';
                            }}
                        >
                            {position.image_url && (
                                <div className="relative h-48 overflow-hidden">
                                    <img
                                        src={position.image_url}
                                        alt={position.name}
                                        className="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                                    />
                                    <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent" />
                                </div>
                            )}
                            <div className="p-6">
                                <h3 className="text-xl font-semibold mb-3" style={{
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
                                {position.button_url ? (
                                    <Link
                                        href={position.button_url}
                                        className="inline-block w-full text-center py-2.5 px-6 rounded-lg text-white font-medium transition-all hover:-translate-y-0.5"
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
                                    </Link>
                                ) : (
                                    <Link
                                        href="/positions"
                                        className="inline-block w-full text-center py-2.5 px-6 rounded-lg text-white font-medium transition-all hover:-translate-y-0.5"
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
                                    </Link>
                                )}
                            </div>
                        </div>
                    ))}
                </div>

                {/* View All Positions Link */}
                <div className="text-center mt-8">
                    <Link
                        href="/positions"
                        className="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all hover:-translate-y-0.5"
                        style={{
                            fontFamily: "'Alexandria', sans-serif",
                            fontWeight: 500,
                            letterSpacing: '0.05em',
                            color: '#e72177',
                            border: '2px solid #e72177',
                        }}
                        onMouseEnter={(e) => {
                            e.currentTarget.style.backgroundColor = '#e72177';
                            e.currentTarget.style.color = '#FFFFFF';
                        }}
                        onMouseLeave={(e) => {
                            e.currentTarget.style.backgroundColor = 'transparent';
                            e.currentTarget.style.color = '#e72177';
                        }}
                    >
                        {locale === 'ar' ? 'عرض جميع الوظائف' : 'View All Positions'}
                        <Briefcase className="h-4 w-4" />
                    </Link>
                </div>
            </div>
        </section>
    );
}

