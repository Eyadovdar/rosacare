<?php

namespace App\Notifications;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewContactNotification extends Notification
{
    use Queueable;

    protected Contact $contact;

    /**
     * Create a new notification instance.
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Contact Message from ' . $this->contact->name)
            ->line('You have received a new contact message.')
            ->line('Name: ' . $this->contact->name)
            ->line('Email: ' . $this->contact->email)
            ->when($this->contact->phone, function ($mail) {
                return $mail->line('Phone: ' . $this->contact->phone);
            })
            ->when($this->contact->subject, function ($mail) {
                return $mail->line('Subject: ' . $this->contact->subject);
            })
            ->line('Message: ' . $this->contact->message)
            ->action('View Message', '/rosa-admin/contacts/' . $this->contact->id);
    }

    /**
     * Get the database representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Contact Message',
            'body' => $this->contact->name . ' (' . $this->contact->email . ') sent a message' . ($this->contact->subject ? ': ' . $this->contact->subject : ''),
            'icon' => 'heroicon-o-envelope',
            'iconColor' => 'primary',
            'contact_id' => $this->contact->id,
            'contact_name' => $this->contact->name,
            'contact_email' => $this->contact->email,
            'url' => '/rosa-admin/contacts/' . $this->contact->id,
        ];
    }

    /**
     * Get the array representation of the notification (for backward compatibility).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}

