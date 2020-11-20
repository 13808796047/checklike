<?php

namespace App\Jobs;

use App\Models\Enum\OrderEnum;
use App\Models\Order;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderPaidMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        if($this->order->status == 1) {
            $data = [
                'first' => '您的论文已经支付成功,点击查看结果',
                'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
                'keyword2' => ['value' => '已支付', 'color' => '#4e9876'],
                'keyword3' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
                'keyword4' => ['value' => $this->order->category->name, 'color' => '#173177'],
                'keyword5' => ['value' => $this->order->price, 'color' => '#173177'],
                'remark' => ['value' => '点击查看详情', 'color' => '#173177']
            ];

            $touser = $this->order->user->weixin_openid;
            $template_id = config('wechat.official_account.templates.paid.template_id');
            $appid = config('wechat.official_account.templates.paid.appid');
            $pagepath = config('wechat.official_account.templates.paid.page_path');
            $config = config('wechat.official_account');

            if($touser) {
                Factory::officialAccount($config)->template_message->send([
                    'touser' => $touser,
                    'template_id' => $template_id,
//                'url' => 'https://wap.lianwen.com/bading?openid=' . $this->order->user->weixin_openid,
                    'miniprogram' => [
                        'appid' => $appid,
                        'pagepath' => $pagepath,
                    ],
                    'data' => $data,
                ]);
            }
        }
    }
}
