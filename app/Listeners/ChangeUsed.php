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
        $user = $event->getUser();
        $couponCode->update([
            'status' => CouponCode::STATUS_ACTIVED,
            'uid' => $user->id
        ]);
        if($couponCode->type == CouponCode::TYPE_VIP) {
            DB::transaction(function() use ($couponCode) {
                $couponCode->user()->update([
                    'user_group' => 3
                ]);
                $couponCode->user()->increment('vip_days', $couponCode->enable_days);
            });
        }
    }
}
