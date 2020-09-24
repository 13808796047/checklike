<?php

namespace App\Policies;

use App\Models\Recharge;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RechargePolicy
{
    use HandlesAuthorization;

    public function ownRecharge(User $user, Recharge $recharge)
    {
        return $user->isBelongOf($recharge);
    }
}
