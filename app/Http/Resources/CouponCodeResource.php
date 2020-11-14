<?php

namespace App\Http\Resources;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponCodeResource extends JsonResource
{
    protected $order;

//    public function __construct($resource, Order $order)
//    {
//        parent::__construct($resource);
//        $this->order = $order;
//    }

    public function toArray($request)
    {
        $data = parent::toArray($request);
        return $data;
    }

    public function showEnableReason($order)
    {
        $this->order = $order;
        return $this;
    }
}
