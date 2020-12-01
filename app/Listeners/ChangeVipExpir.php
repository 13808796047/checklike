<?php

namespace App\Listeners;

use App\Events\RefreshPaged;
use Carbon\Carbon;
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
        $user = $event->user;
        if($user->user_group != 3) {
            return;
        }
        if($user->vip_expir_at->lt(Carbon::now())) {
            $user->update([
                'user_group' => 0,
                'vip_days' => 0,
                'is_free' => false,
                'vip_expir_at' => null
            ]);
        }
    }
}
