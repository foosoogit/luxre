<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public array $target_item_array)
    {
        //$this->name = $name;
        //$this->email = $email;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->target_item_array['subject'],
            to: $this->target_item_array['to_email'],
            replyTo: $this->target_item_array['from_email'],
            from: $this->target_item_array['from_email'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            //html: 'emails.test',
            //view: 'view.SendQrToStaff',
            view: 'emails.SendQrToStaff',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            $this->target_item_array['QR_file_path']
            //Attachment::fromPath('/path/to/file'),
        ];
    }
}
