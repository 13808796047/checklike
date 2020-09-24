<?php

namespace App\Jobs;

use App\Handlers\OrderApiHandler;
use App\Models\Enum\OrderEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class getOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $timeout = 60;
    protected $tries = 3;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function handle()
    {
        $api = app(OrderApiHandler::class);
        $result = $api->getOrder($this->order->api_orderid);
        if($result->code == 200) {
            switch ($result->data->order->status) {
                case 7:
                    $status = OrderEnum::INLINE;
                    break;
                case 9:
                    $status = OrderEnum::CHECKED;
                    dispatch(new CheckOrderStatus($this->order));
                    break;
                default:
                    $status = OrderEnum::CHECKING;
                    dispatch(new getOrderStatus($this->order))->delay(now()->addMinutes());
            }
            \DB::transaction(function() use ($status) {
                $this->order->update([
                    'status' => $status,
                ]);
            });
        }
    }
}
