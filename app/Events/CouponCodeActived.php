<?php

namespace App\Events;

use App\Models\CouponCode;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CouponCodeActived
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $coupon_code;
    protected $user;

    public function __construct(CouponCode $coupon_code, $user)
    {
        $this->user = $user;
        $this->coupon_code = $coupon_code;
    }

    public function getCouponCode()
    {
        return $this->coupon_code;
    }

    public function getUser()
    {
        return $this->user;
    }
}
