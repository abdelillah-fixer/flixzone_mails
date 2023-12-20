<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;

    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    public function build()
    {
        $subject = 'Subscription Confirmation';

        $content = "<html><body>";
        $content .= "<h1>Hello, " . $this->userName . "!</h1>";
        $content .= "<p>Your subscription has been confirmed. Thank you for subscribing.</p>";
        $content .= "</body></html>";

        return $this->subject($subject)->html($content);
    }
}
