<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HiredEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $position;
    public $department;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $position, $department)
    {
        $this->name = $name;
        $this->position = $position;
        $this->department = $department;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('jhonmente4@gmail.com', 'HRIS- A One Stop Employee Management'),
            subject: 'Hired Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'users.hrofficer.mail.hired-email',
            with: [
                'name' => $this->name,
                'position' => $this->position,
                'department' => $this->department
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
