<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;

    /**
     * Terima data peserta saat kelas ini dipanggil
     */
    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * Judul Email
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tiket Resmi AMPERA IMP 2026 - ' . $this->registration->name,
        );
    }

    /**
     * Menunjuk file tampilan (View) email
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket_approved',
        );
    }
}