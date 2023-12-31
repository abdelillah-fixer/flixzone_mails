<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Mail;
class ContactController extends Controller
{
    public function contact_mail_send(Request $request) {
        $contactRequest = $request->all();
        $mailData = [
            'name' => $contactRequest['name'],
            'email' => $contactRequest['email'],
            'subject' => $contactRequest['subject'],
            'message' => $contactRequest['message']
        ];
    
        Mail::to('abdelillahfixer123@gmail.com')->send(new ContactMail($mailData));
    
     
    }
}
