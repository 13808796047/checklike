<?php

namespace App\Listeners;

use App\Events\CheckVipExpirAt;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateVipExpirAt implements ShouldQueue
{
    
    public function handle(CheckVipExpirAt $event)
    {
        $user = $event->getUser();
        if($user->user_group != 3) {
            return;
        }
        if($user->vip_expir_at->lt(Carbon::now())) {
            $user->update([
                'user_group' => 3
            ]);
        }
    }
}
