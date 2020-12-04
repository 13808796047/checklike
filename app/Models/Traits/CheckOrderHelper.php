<?php

namespace App\Models\Traits;

use App\Handlers\OrderApiHandler;
use App\Jobs\CheckOrderStatus;
use App\Jobs\getOrderStatus;
use App\Models\Enum\OrderEnum;
use App\Models\Order;
use Illuminate\Support\Facades\Log;


trait CheckOrderHelper
{
    public function getOrderStatus()
    {
        $orders = Order::query()->where('status', 4)->orWhere('status', 3)->get();
        foreach($orders as $order) {
            if($order->status == 3) {
                dispatch(new getOrderStatus($order));
            }
            if($order->status == 4 && $order->report_path == '') {
                dispatch(new CheckOrderStatus($order));
            }
        }
    }
}
