<?php

namespace App\Mail;

use App\Models\PositionApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class PositionApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public PositionApplication $application
    ) {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $positionName = $this->application->position->translate('en')?->name 
            ?? $this->application->position->translate('ar')?->name 
            ?? 'Position';
            
        return new Envelope(
            subject: "New Job Application: {$positionName} - {$this->application->name}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.position-application-notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if (!$this->application->cv_path) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->application->cv_path)
                ->as($this->application->cv_filename)
                ->withMime(Storage::disk('public')->mimeType($this->application->cv_path)),
        ];
    }
}
