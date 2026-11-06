<?php

namespace App\Mail;

use App\Models\Consultation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ConsultationReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public Consultation $consultation;
    public string $replyMessage;

    /**
     * Create a new message instance.
     */
    public function __construct(Consultation $consultation, string $replyMessage)
    {
        $this->consultation = $consultation;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tanggapan Konsultasi #' . substr($this->consultation->ticket_id, 0, 8) . ' - Pojok UMKM Wonogiri',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.consultation_reply',
            with: [
                'consultation' => $this->consultation,
                'replyMessage' => $this->replyMessage,
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

