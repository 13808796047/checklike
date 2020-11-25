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

class StartCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function handle()
    {
        $api = app(OrderApiHandler::class);
        $result = $api->startCheck($this->order->api_orderid);
        if($this->order->status == 2) {
            return;
        }
        if($result->code == 200 && $this->order->status == 1) {
            if($this->order->user->user_group != 3) {
                $this->order->user->update([
                    'is_free' => false,
                ]);
            }
            dispatch(new UpdateIsFree($this->order))->delay(now()->addMinute());
            dispatch(new getOrderStatus($this->order))->delay(now()->addMinutes());
            $this->order->update([
                'status' => 3,
            ]);
        }
    }

    /**
     * 任务未能处理
     */
    public function failed(\Throwable $exception)
    {
        $data = [
            'first' => '有订单异常,请尽快处理!(开始检测队列)',
            'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
            'keyword2' => ['value' => OrderEnum::getStatusName($this->order->status), 'color' => '#173177'],
            'keyword3' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
            'keyword4' => ['value' => $this->order->category->name, 'color' => '#173177'],
            'keyword5' => ['value' => $this->order->price, 'color' => '#173177'],
            'remark' => ['value' => '点击查看详情！', 'color' => '#173177']
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
