<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestResultPaymentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $link;
    public function __construct($message, $link)
    {
        $this->link = $link;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Tilt - Payment for Test Result")
            ->markdown('emails.payments.test-result');
    }
}
