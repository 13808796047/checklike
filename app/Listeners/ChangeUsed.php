<?php

namespace App\Listeners;

use App\Events\CouponCodeActived;
use App\Jobs\ChangeVip;
use App\Models\CouponCode;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class ChangeUsed implements ShouldQueue
{
    public function handle(CouponCodeActived $event)
    {
        $couponCode = $event->getCouponCode();
        $user = $event->getUser();
        $couponCode->update([
            'status' => CouponCode::STATUS_ACTIVED,
            'actived_at' => Carbon::now(),
            'uid' => $user->id
        ]);
        if($couponCode->type == CouponCode::TYPE_VIP) {
            $user->update([
                'user_group' => 3
            ]);
            $user->changeDays($couponCode->enable_days);
            $couponCode = CouponCode::where('uid', $user->id)->first();
            dispatch(new ChangeVip($user))->delay(Carbon::parse($couponCode->actived_at)->addDays($user->vip_days));
        }
    }
}
