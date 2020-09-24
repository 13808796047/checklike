<?php

namespace App\Jobs;

use App\Handlers\OrderApiHandler;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateCheckOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $file;

    public function __construct(Order $order, $file)
    {
        $this->order = $order;
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = app(OrderApiHandler::class);
        //调用创建apiOrder
        $result = $api->createOrder($this->order, $this->file);
        if($result->code == 200) {
            $this->order->update([
                'api_orderid' => $result->data,
            ]);
            dispatch(new StartCheck($this->order));
        }
    }
}
