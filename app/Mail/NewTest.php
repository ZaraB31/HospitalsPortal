<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Test;

class NewTest extends Mailable
{
    use Queueable, SerializesModels;

    public $test;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Test $test)
    {
        $this->test = $test;
    }

    public function envelope()
    {
        return new Envelope(
            from: new Address('megaelectrical.testion@gmail.com', 'Mega Electrical Testing'),
            subject: 'New Test',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.NewTest',
        );
    }
}
