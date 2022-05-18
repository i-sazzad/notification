<?php

namespace Imran\Notification;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
//        $this->loadRoutesFrom(__DIR__.'/routes.php');
//        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views/notification', 'notification');
        $this->publishes([
            __DIR__.'/views/notification' => base_path('resources/views/notification'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function register()
    {
        $this->app->register(NotificationEventServiceProvider::class);
//        $this->app->make('imran\notification\NotificationController');
    }
}
