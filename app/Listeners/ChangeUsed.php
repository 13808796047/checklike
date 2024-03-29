<?php

namespace App\Listeners;

use App\Events\CouponCodeActived;
use App\Jobs\ChangeVip;
use App\Models\CouponCode;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChangeUsed implements ShouldQueue
{
    public function handle(CouponCodeActived $event)
    {
        $couponCode = $event->getCouponCode();
        $user = $event->getUser();
        $couponCode->status = CouponCode::STATUS_ACTIVED;
        $couponCode->actived_at = now();
        $couponCode->user()->associate($user);
        $couponCode->save();
        if($couponCode->type == CouponCode::TYPE_VIP) {
            if(!$user->vip_expir_at) {
                $vip_expir_at = Carbon::now()->addDays($couponCode->enable_days);
            }
            $vip_expir_at = Carbon::parse($user->vip_expir_at)->addDays($couponCode->enable_days);
            $user->update([
                'user_group' => 3,
                'vip_expir_at' => $vip_expir_at,
            ]);
            $user->changeDays($couponCode->enable_days);
        }
    }
}
