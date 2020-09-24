<?php

namespace App\Listeners;

use App\Events\RechargePaid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserJctimes
{

    public function handle(RechargePaid $event)
    {
        //从事件中取出对应的订单
        $recharge = $event->getRecharge();
        $recharge->user->increaseJcTimes($recharge->amount);
    }
}
