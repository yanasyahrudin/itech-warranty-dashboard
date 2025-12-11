<?php

namespace App\Mail;

use App\Models\WarrantyRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WarrantyApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public WarrantyRegistration $registration
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Warranty Registration Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.warranty-approved',
        );
    }
}