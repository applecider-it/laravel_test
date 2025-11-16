<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Event;

use App\Listeners\TestListener;
use App\Listeners\Test2Listener;
use App\Events\TestEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(TestEvent::class,  TestListener::class,);
        Event::listen(TestEvent::class, Test2Listener::class,);
    }
}
