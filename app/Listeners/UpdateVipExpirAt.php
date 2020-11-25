<?php

namespace App\Listeners;

use App\Events\RefreshPaged;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateVipExpirAt implements ShouldQueue
{

    public function handle(RefreshPaged $event)
    {
        Log::alert('event', $event);
        $user = $event->user;
        Log::alert('user' . $user->nickname);
        if($user->user_group != 3) {
            return;
        }
        if($user->vip_expir_at->lt(Carbon::now())) {
            $user->update([
                'user_group' => 0
            ]);
        }
    }
}
