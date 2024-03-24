<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index(){
        $subject = "Email.test";
        $body="Hello messge from my app. Say hi to kim. You are a GOAT";
        

        try {
            Mail::to('joynkatha803@gmail.com')->send(new TestMail($subject,$body));
            return("message sent");
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
