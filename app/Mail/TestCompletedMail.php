<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestCompletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $link;

    public function __construct($name, $link)
    {
        $this->name=$name;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Test Completed')
            ->markdown('emails.test-completed');
    }
}
