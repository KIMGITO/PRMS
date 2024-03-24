<?php

namespace App\Listeners;

use App\Events\UserWithOTPCreated;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOTP implements ShouldQueue
{

    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserWithOTPCreated $event)
    {
        // $user = $event->user;
        $otp = $event->otp;
        $email = $event->email;
        $subject = $event->subject;
        
       if( Mail::to($email)->send(new TestMail($subject, $otp))){
    }

    }
}
