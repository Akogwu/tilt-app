<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $schoolName;

    public function __construct($name, $schoolName)
    {
        $this->name=$name;
        $this->schoolName = $schoolName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.welcome-admin');
    }
}
