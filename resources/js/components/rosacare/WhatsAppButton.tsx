import { useState, useEffect, useRef } from 'react';
import { usePage } from '@inertiajs/react';

interface WhatsAppButtonProps {
    whatsappUrl?: string;
    showButton?: boolean;
    locale?: string;
}

export function WhatsAppButton({ whatsappUrl, showButton = true, locale = 'ar' }: WhatsAppButtonProps) {
    const [isOpen, setIsOpen] = useState(false);
    const [message, setMessage] = useState('');
    const textareaRef = useRef<HTMLTextAreaElement>(null);
    const page = usePage<any>();
    const settings = page.props.settings;

    // Get WhatsApp URL from props or settings
    const whatsapp = whatsappUrl || settings?.whatsapp;
    // Show if show_whatsapp_button is truthy (1 or true)
    const shouldShow = showButton && !!settings?.show_whatsapp_button && whatsapp;

    useEffect(() => {
        if (isOpen && textareaRef.current) {
            textareaRef.current.focus();
        }
    }, [isOpen]);

    if (!shouldShow || !whatsapp) {
        return null;
    }

    const handleSend = () => {
        if (!message.trim()) {
            return;
        }

        // Extract phone number from WhatsApp URL
        // WhatsApp URL format: https://wa.me/1234567890 or https://api.whatsapp.com/send?phone=1234567890
        let phoneNumber = '';
        let whatsappUrlToUse = whatsapp;

        // Check if it's a direct phone number URL
        if (whatsapp.includes('wa.me/')) {
            phoneNumber = whatsapp.split('wa.me/')[1]?.split('?')[0] || '';
        } else if (whatsapp.includes('api.whatsapp.com/send')) {
            const urlParams = new URLSearchParams(whatsapp.split('?')[1] || '');
            phoneNumber = urlParams.get('phone') || '';
        } else if (whatsapp.includes('whatsapp.com/send')) {
            const urlParams = new URLSearchParams(whatsapp.split('?')[1] || '');
            phoneNumber = urlParams.get('phone') || '';
        }

        // Build WhatsApp URL with message
        const encodedMessage = encodeURIComponent(message.trim());
        let finalUrl = '';

        if (phoneNumber) {
            // Remove any non-digit characters except + from phone number
            const cleanPhone = phoneNumber.replace(/[^\d+]/g, '');
            finalUrl = `https://wa.me/${cleanPhone}?text=${encodedMessage}`;
        } else {
            // If we can't extract phone, append message to existing URL
            const separator = whatsapp.includes('?') ? '&' : '?';
            finalUrl = `${whatsapp}${separator}text=${encodedMessage}`;
        }

        // Open WhatsApp
        window.open(finalUrl, '_blank');

        // Reset and close
        setMessage('');
        setIsOpen(false);
    };

    const handleKeyDown = (e: React.KeyboardEvent<HTMLTextAreaElement>) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    };

    const isRTL = locale === 'ar';

    return (
        <>
            <style>{`
                @keyframes slideUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                .whatsapp-box {
                    animation: slideUp 0.3s ease-out;
                }
            `}</style>

            {/* WhatsApp Floating Button */}
            <button
                onClick={() => setIsOpen(!isOpen)}
                className={`fixed bottom-6 z-50 w-14 h-14 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-110 flex items-center justify-center ${isRTL ? 'left-6' : 'right-6'}`}
                style={{
                    background: 'linear-gradient(135deg, #25D366, #128C7E)',
                    boxShadow: '0 4px 20px rgba(37, 211, 102, 0.4)',
                }}
                aria-label="WhatsApp"
            >
                <svg
                    width="28"
                    height="28"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
                        fill="white"
                    />
                </svg>
            </button>

            {/* WhatsApp Message Box */}
            {isOpen && (
                <div
                    className={`fixed ${isRTL ? 'left-6' : 'right-6'} bottom-24 z-50 whatsapp-box`}
                    style={{ width: '320px' }}
                >
                    <div
                        className="rounded-2xl shadow-2xl overflow-hidden"
                        style={{
                            background: '#e5ddd5',
                            backgroundImage: 'url("data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cdefs%3E%3Cpattern id=\'a\' patternUnits=\'userSpaceOnUse\' width=\'100\' height=\'100\' patternTransform=\'scale(0.5) rotate(0)\'%3E%3Crect x=\'0\' y=\'0\' width=\'100\' height=\'100\' fill=\'hsla(0,0%25,100%25,0)\'/%3E%3Cpath d=\'M-50 0h100v100h-100z M0-50h100v100h-100z\' stroke-width=\'0.5\' stroke=\'hsla(259,0%25,0%25,0.05)\' fill=\'none\'/%3E%3C/pattern%3E%3C/defs%3E%3Crect fill=\'url(%23a)\' width=\'100\' height=\'100\'/%3E%3C/svg%3E")',
                        }}
                    >
                        {/* Header */}
                        <div
                            className="px-4 py-3 flex items-center justify-between"
                            style={{
                                background: 'linear-gradient(135deg, #075e54, #128c7e)',
                            }}
                        >
                            <div className="flex items-center gap-3">
                                <div
                                    className="w-10 h-10 rounded-full flex items-center justify-center"
                                    style={{ background: 'rgba(255, 255, 255, 0.2)' }}
                                >
                                    <svg
                                        width="20"
                                        height="20"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
                                            fill="white"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <div className="text-white font-semibold text-sm" style={{ fontFamily: "'Alexandria', sans-serif" }}>
                                        {locale === 'ar' ? 'RosaCare' : 'RosaCare'}
                                    </div>
                                    <div className="text-white text-xs opacity-90" style={{ fontFamily: "'Alexandria', sans-serif" }}>
                                        {locale === 'ar' ? 'متصل الآن' : 'Online'}
                                    </div>
                                </div>
                            </div>
                            <button
                                onClick={() => setIsOpen(false)}
                                className="text-white hover:opacity-70 transition-opacity"
                                aria-label="Close"
                            >
                                <svg
                                    width="20"
                                    height="20"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                >
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>

                        {/* Message Input Area */}
                        <div className="p-4">
                            <div className="mb-3">
                                <textarea
                                    ref={textareaRef}
                                    value={message}
                                    onChange={(e) => setMessage(e.target.value)}
                                    onKeyDown={handleKeyDown}
                                    placeholder={locale === 'ar' ? 'اكتب رسالتك...' : 'Type a message...'}
                                    className="w-full px-4 py-3 rounded-lg resize-none border-none focus:outline-none focus:ring-2 focus:ring-green-500"
                                    style={{
                                        fontFamily: "'Alexandria', sans-serif",
                                        fontSize: '14px',
                                        minHeight: '80px',
                                        maxHeight: '120px',
                                        background: '#ffffff',
                                    }}
                                    rows={3}
                                />
                            </div>
                            <button
                                onClick={handleSend}
                                disabled={!message.trim()}
                                className="w-full py-2.5 rounded-lg font-medium transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed hover:opacity-90"
                                style={{
                                    background: message.trim() ? 'linear-gradient(135deg, #25D366, #128C7E)' : '#cccccc',
                                    color: '#ffffff',
                                    fontFamily: "'Alexandria', sans-serif",
                                }}
                            >
                                {locale === 'ar' ? 'إرسال' : 'Send'}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
