<?php

namespace App\Listeners;

use App\EventsModel;
use App\Events\HandleTestEvent;
use App\Library\Algorithm\HandleResults;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class HandleTest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        // TODO
    }

    /**
     * Handle the event.
     *
     * @param  HandleTestEvent $event
     * @return void
     */
    public function handle(HandleTestEvent $event)
    {
        new HandleResults($event->file, $event->transaction);
    }
}
