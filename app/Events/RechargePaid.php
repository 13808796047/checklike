<?php

namespace App\Events;

use App\Models\Recharge;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RechargePaid
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $recharge;

    public function __construct(Recharge $recharge)
    {
        $this->recharge = $recharge;
    }

    public function getRecharge()
    {
        return $this->recharge;
    }
}
