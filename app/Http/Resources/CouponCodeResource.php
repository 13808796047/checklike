<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponCodeResource extends JsonResource
{
    protected $order;

    public function toArray($request)
    {
        $data['reason'] = '';
        if($this->order->price < $this->min_amount) {
            $data['reason'] = '满减金额不符合';
        }
        if($this->order->cid != $this->cid) {
            $data['reason'] = '此系统不符合使用';
        }
        if($this->order->price < $this->min_amount || $this->order->cid != $this->cid) {
            $data['reason'] = '满减金额或此系统不符合使用';
        }
        $data = parent::toArray($request);
        return $data;
    }

    public function showEnableReason(Order $order)
    {
        $this->order = $order;
        return $this;
    }
}
