<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class InitialInterviewMail extends Mailable
{
    use Queueable, SerializesModels;
    public $applicant_name;
    public $job_title;
    public $date;
    public $time;
    /**
     * Create a new message instance.
     */
    public function __construct($applicant_name, $job_title, $date, $time)
    {
        $this->applicant_name = $applicant_name;
        $this->date = $date;
        $this->job_title = $job_title;
        $this->time = $time;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('jhonmente4@gmail.com', 'HRIS- A One Stop Employee Management'),
            subject: 'Initial Interview Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'users.hrofficer.mail.initial-interview-email',
            with : [
                'name' => $this->applicant_name,
                'job_title' => $this->job_title,
                'date' => $this->date,
                'time' => $this->time,
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
