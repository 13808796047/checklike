<?php

namespace App\Listeners;

use App\Events\CouponCodeActived;
use App\Models\CouponCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class ChangeUsed
{
    public function handle(CouponCodeActived $event)
    {
        $couponCode = $event->getCouponCode();
        $couponCode->update([
            'status' => CouponCode::STATUS_ACTIVED
        ]);
        if($couponCode->type == CouponCode::TYPE_VIP) {
            DB::transaction(function() use ($couponCode) {
                $couponCode->user()->update([
                    'user_group' => 3
                ]);
                $couponCode->user->changeDays($couponCode->enable_days);
            });
        }
    }
}
