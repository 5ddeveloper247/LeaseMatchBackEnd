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
    public $packageName;
    public $renewalDate;
    public $nextBillingDate;
    public $amount;
    public $newExpiryDate;
    public $supportEmail;

    public function __construct($user, $packageName, $renewalDate, $nextBillingDate, $amount, $newExpiryDate)
    {
        $this->user = $user;
        $this->packageName = $packageName;
        $this->renewalDate = $renewalDate;
        $this->nextBillingDate = $nextBillingDate;
        $this->amount = $amount;
        $this->newExpiryDate = $newExpiryDate;
        $this->supportEmail = env('SUPPORT_EMAIL', 'info@leasematch.nyc');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Subscription Has Been Renewed Successfully',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.subscription_expiry',
            with: [
                'user' => $this->user,
                'packageName' => $this->packageName,
                'renewalDate' => $this->renewalDate,
                'nextBillingDate' => $this->nextBillingDate,
                'amount' => $this->amount,
                'newExpiryDate' => $this->newExpiryDate,
                'supportEmail' => $this->supportEmail,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
