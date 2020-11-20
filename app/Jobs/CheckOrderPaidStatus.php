<?php

namespace App\Jobs;

use App\Models\Enum\OrderEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckOrderPaidStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        if($this->order->status == OrderEnum::UNCHECK) {
            $data = [
                'first' => '有订单异常,请尽快处理!(未开始检测)',
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
}
