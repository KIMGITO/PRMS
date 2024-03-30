<?php

namespace App\Providers;

use App\Events\ResetPasswordRequest;
use App\Events\UserWithOTPCreated;
use App\Listeners\SendOTP;
use App\Listeners\SendPasswordResetLink;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserWithOTPCreated::class => [
            SendOTP::class
        ],
        ResetPasswordRequest::class => [
            SendPasswordResetLink::class    
        ]
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
