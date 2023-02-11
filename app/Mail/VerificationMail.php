<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * VerificationMail class
 *
 * @category Mail
 *
 * @author DmitryKoryagin <kor.dima97@mail.ru>
 */
class VerificationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var int
     */
    public int $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(int $code)
    {
        $this->code = $code;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope() : Envelope
    {
        return new Envelope(
            subject: 'Подтверждение почты',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content() : Content
    {
        return new Content(
            view: 'mail.verification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments() : array
    {
        return [];
    }
}
