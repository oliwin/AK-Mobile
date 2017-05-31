<?php

namespace App\Library;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use App\Http\Requests;

class Mailer
{

    public function send($data)
    {

        Mail::send('emails.conclusion', ["conclusion" => $data["body"]], function ($message) use ($data) {
            $message->subject($data["subject"]);
            $message->to(config('app.email_admin'), $data["name"]);
        });
    }
}