<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubscriptionExpiryMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    
    public function __construct($user)
    {
        //
        // dd('ok');
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Subscription is About to Expire – Action Required',
        );
    }

    public function content(): Content
    {
        // dd('ok');
        return new Content(
            view: 'emails.subscription_expiry',
            with: ['user' => $this->user],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}