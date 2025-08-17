<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriberNewsMail extends Mailable 
{
    use Queueable, SerializesModels;

    public $subscriber;
    public $newsList;

    public function __construct($subscriber, $newsList)
    {
        $this->subscriber = $subscriber;
        $this->newsList   = $newsList;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Selected News',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscriber-news',
            with: [
                'subscriber' => $this->subscriber,
                'newsList'   => $this->newsList,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
