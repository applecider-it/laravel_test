<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Event;

use App\Listeners\SampleListener;
use App\Listeners\Sample2Listener;
use App\Events\SampleEvent;

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
        Event::listen(SampleEvent::class, SampleListener::class);
        Event::listen(SampleEvent::class, Sample2Listener::class);
    }
}
