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
        } else {
            $status = OrderEnum::CHECKING;
            dispatch(new getOrderStatus($this->order))->delay(now()->addMinutes());
        }
        \DB::transaction(function() use ($status) {
            $this->order->update([
                'status' => $status,
            ]);
        });
    }

    /**
     * 任务未能处理
     */
    public function failed(\Throwable $exception)
    {
        $data = [
            'first' => '检测文件获取队列通知',
            'keyword1' => ['value' => '检测文件获取队列发生错误', 'color' => '#173177'],
        ];
        $touser = config('wechat.notify_openid');
        $template_id = config('wechat.official_account.templates.pending.template_id');
        if($touser) {
            app('official_account')->template_message->send([
                'touser' => $touser,
                'template_id' => $template_id,
                'data' => $data,
            ]);
        }
    }
}
