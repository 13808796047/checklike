<?php

namespace App\Listeners;

use App\Events\CouponCodeActived;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ChangeUsed
{
    public function __construct()
    {
        //
    }

    public function handle(CouponCodeActived $event)
    {
        $couponCode = $event->getCouponCode();
        if($couponCode->type==){

        }
    }
}
