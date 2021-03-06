<?php

namespace App\Listeners;

use App\Events\Invited;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActiveVip
{

    public function handle(Invited $event)
    {
        $user = $event->user;
        $vip_expir_at = Carbon::parse($user->vip_expir_at)->addDays(30);
        $user->update([
            'user_group' => 3,
            'vip_expir_at' => $vip_expir_at,
        ]);
        $user->changeDays(30);
    }
}
