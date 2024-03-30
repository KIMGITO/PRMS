<?php

namespace App\Listeners;

use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Log;
use App\Events\ResetPasswordRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class SendPasswordResetLink
{
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
    public function handle(ResetPasswordRequest $event)
    {
        $subject = $event->subject;
        $body =$event->body;
        $email = $event->email;

        try{
            Mail::to($email)->send(new ResetPassword($subject,$body));
        } catch (\Exception $e) {
            return $this->handleEmailError($e);
        }

    }
    protected function handleEmailError(\Exception $e)
        {
            // Log the error
            Log::error('Email sending failed: ' . $e->getMessage());
            if(!$e->getCode()){
                return "There was no connection. Please reconnect and try again";
            }else{
                return "An error occured. Please try again later";
            }
            
        }
}
