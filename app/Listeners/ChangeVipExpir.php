<?php

namespace App\Listeners;

use App\Events\RefreshPaged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ChangeVipExpir
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param RefreshPaged $event
     * @return void
     */
    public function handle(RefreshPaged $event)
    {
        Log::alert('alls', [$event->user]);
    }
}
