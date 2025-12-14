<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class InviteUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $inviteCode;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $inviteCode)
    {
        $this->user = $user;
        $this->inviteCode = $inviteCode;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Undangan Bergabung - Sistem Informasi Pertanahan Nasional',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invite',
            with: [
                'user' => $this->user,
                'inviteCode' => $this->inviteCode,
                'inviteUrl' => url('/register?invite=' . $this->inviteCode),
            ],
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
