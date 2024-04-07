<?php

namespace App\Listeners;

use App\Events\ActivityProcessed;
use App\Http\Controllers\LoggedActivityController;
use App\Models\LoggedActivities;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterNewActivity
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
    public function handle(ActivityProcessed $event): void
    {
        $user = $event->user;
        $description = $event->description;
        $action = $event->action;
        $status = $event->status;
        $addActivity = new LoggedActivityController;

        $store = $addActivity->store($user, $description, $action, $status);
    }
}
