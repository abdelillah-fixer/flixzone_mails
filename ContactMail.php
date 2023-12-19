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
        $this->mailData = $mailData;
    }
    
    public function build() {
        return $this->view('emails.contact')->with('mailData', $this->mailData);
    }
}