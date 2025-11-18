<?php

namespace App\Listeners;

use App\Events\SampleEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Log;

class Sample2Listener
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
    public function handle(SampleEvent $event): void
    {
        Log::info('Sample2Listener handle', [$event->user->toArray()]);
    }
}
