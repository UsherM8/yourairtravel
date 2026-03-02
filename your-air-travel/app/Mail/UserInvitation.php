<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $inviteUrl;

    public function __construct($user, $inviteUrl)
    {
        $this->user = $user;
        $this->inviteUrl = $inviteUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Uitnodiging: Stel je wachtwoord in voor YourAirTravel',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-invitation',
        );
    }
}
