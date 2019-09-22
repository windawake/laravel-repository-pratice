<?php

namespace App\Providers;

use App\Events\ModelCreatedEvent;
use App\Events\ModelDeletedEvent;
use App\Events\ModelUpdatedEvent;
use App\Listeners\ModelCreatedListener;
use App\Listeners\ModelDeletedListener;
use App\Listeners\ModelUpdatedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ModelCreatedEvent::class => [
            ModelCreatedListener::class
        ],
        ModelUpdatedEvent::class => [
            ModelUpdatedListener::class
        ],
        ModelDeletedEvent::class => [
            ModelDeletedListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
