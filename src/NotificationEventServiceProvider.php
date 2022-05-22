<?php

namespace Ranger\Notification;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Ranger\Notification\Events\NotificationEvent;
use Ranger\Notification\Listeners\NotificationListener;

class NotificationEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NotificationEvent::class => [
            NotificationListener::class,
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
