<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    public $name;
    public $email;
    public $subject;
    public $message;
    
    public function __construct($mailData) {
        $this->name = $mailData['name'];
        $this->email = $mailData['email'];
        $this->subject = $mailData['subject'];
        $this->message = $mailData['message'];
    }
    
    public function build() {
        $subject = 'Contact Form Submission: ' . $this->subject;

        $content = "<html><body>";
        $content .= "<h2>Contact Form Submission</h2>";
        $content .= "<p><strong>Name:</strong> " . $this->name . "</p>";
        $content .= "<p><strong>Email:</strong> " . $this->email . "</p>";
        $content .= "<p><strong>Subject:</strong> " . $this->subject . "</p>";
        $content .= "<p><strong>Message:</strong> " . $this->message . "</p>";
        $content .= "</body></html>";

        return $this->subject($subject)->html($content);
    }
}
