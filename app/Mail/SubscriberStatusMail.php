<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriberStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $status;
    public $customMessage;

    /**
     * Create a new message instance.
     */
    
    public function __construct($subscriber, $status, $customMessage = null)
    {
        $this->subscriber    = $subscriber;
        $this->status        = $status;
        $this->customMessage = $customMessage;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Subscription Status Update'
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.subscriber-status',
            with: [
                'subscriber' => $this->subscriber,
                'status' => $this->status,
            ]
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
