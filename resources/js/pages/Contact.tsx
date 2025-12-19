import { Head, useForm } from '@inertiajs/react';
import { Footer } from '@/components/rosacare/Footer';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { InputError } from '@/components/input-error';

interface ContactProps {
    locale?: string;
}

export default function Contact({ locale = 'en' }: ContactProps) {
    const isRTL = locale === 'ar';
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

    return (
        <>
            <Head title={locale === 'ar' ? 'اتصل بنا - روزاكير' : 'Contact Us - RosaCare'} />
            <div className={`min-h-screen ${isRTL ? 'rtl' : 'ltr'}`} dir={isRTL ? 'rtl' : 'ltr'}>
                <section className="py-20 bg-secondary/30">
                    <div className="container mx-auto px-4">
                        <div className="max-w-2xl mx-auto">
                            <h1 className={`text-4xl md:text-5xl font-bold mb-8 text-center ${isRTL ? 'rtl' : 'ltr'}`}>
                                {locale === 'ar' ? 'اتصل بنا' : 'Contact Us'}
                            </h1>
                            <Card>
                                <CardHeader>
                                    <CardTitle>
                                        {locale === 'ar' ? 'نحن هنا لمساعدتك' : 'We\'re here to help'}
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <form onSubmit={submit} className="space-y-6">
                                        <div>
                                            <Label htmlFor="name">
                                                {locale === 'ar' ? 'الاسم' : 'Name'} *
                                            </Label>
                                            <Input
                                                id="name"
                                                type="text"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                className="mt-1"
                                            />
                                            <InputError message={errors.name} className="mt-2" />
                                        </div>

                                        <div>
                                            <Label htmlFor="email">
                                                {locale === 'ar' ? 'البريد الإلكتروني' : 'Email'} *
                                            </Label>
                                            <Input
                                                id="email"
                                                type="email"
                                                value={data.email}
                                                onChange={(e) => setData('email', e.target.value)}
                                                className="mt-1"
                                            />
                                            <InputError message={errors.email} className="mt-2" />
                                        </div>

                                        <div>
                                            <Label htmlFor="phone">
                                                {locale === 'ar' ? 'الهاتف' : 'Phone'}
                                            </Label>
                                            <Input
                                                id="phone"
                                                type="tel"
                                                value={data.phone}
                                                onChange={(e) => setData('phone', e.target.value)}
                                                className="mt-1"
                                            />
                                            <InputError message={errors.phone} className="mt-2" />
                                        </div>

                                        <div>
                                            <Label htmlFor="subject">
                                                {locale === 'ar' ? 'الموضوع' : 'Subject'}
                                            </Label>
                                            <Input
                                                id="subject"
                                                type="text"
                                                value={data.subject}
                                                onChange={(e) => setData('subject', e.target.value)}
                                                className="mt-1"
                                            />
                                            <InputError message={errors.subject} className="mt-2" />
                                        </div>

                                        <div>
                                            <Label htmlFor="message">
                                                {locale === 'ar' ? 'الرسالة' : 'Message'} *
                                            </Label>
                                            <textarea
                                                id="message"
                                                value={data.message}
                                                onChange={(e) => setData('message', e.target.value)}
                                                rows={6}
                                                className="mt-1 block w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            />
                                            <InputError message={errors.message} className="mt-2" />
                                        </div>

                                        <Button type="submit" disabled={processing} className="w-full">
                                            {processing
                                                ? (locale === 'ar' ? 'جاري الإرسال...' : 'Sending...')
                                                : (locale === 'ar' ? 'إرسال' : 'Send Message')}
                                        </Button>
                                    </form>
                                </CardContent>
                            </Card>
                        </div>
                    </div>
                </section>
                <Footer locale={locale} />
            </div>
        </>
    );
}
