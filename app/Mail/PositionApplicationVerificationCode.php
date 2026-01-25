<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PositionApplicationVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $locale;

    /**
     * Create a new message instance.
     */
    public function __construct($code, $locale = 'en')
    {
        $this->code = $code;
        $this->locale = $locale;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->locale === 'ar' 
            ? 'رمز التحقق لتقديم طلب الوظيفة - روزاكير'
            : 'Position Application Verification Code - RosaCare';
        
        // Use the same email as username for From address to avoid SMTP rejection
        $fromAddress = config('mail.mailers.smtp.username') ?: config('mail.from.address');
        $fromName = config('mail.from.name');
            
        return new Envelope(
            subject: $subject,
            from: new Address($fromAddress, $fromName),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.position-application-verification-code',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
