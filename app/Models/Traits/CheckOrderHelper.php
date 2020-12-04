<?php

namespace App\Models\Traits;

use App\Events\OrderPaid;
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
        $orders = Order::query()->where(['status' => 1, 'checked' => false])->get();
        foreach($orders as $order) {
            if($order->category->check_type == 1) {
                event(new OrderPaid($order));
            }
            $order->update([
                'checked' => true
            ]);
        }
    }
}
