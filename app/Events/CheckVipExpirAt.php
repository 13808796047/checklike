<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckVipExpirAt
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        Log::info('dsa', [$user]);
        $this->user = $user;
    }

    public function getUser()
    {
        Log::info('dsa', [$this->user]);

        return $this->user;
    }
}
