<?php

namespace App\Jobs;

use App\Models\Enum\OrderEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Overtrue\EasySms\EasySms;

class IOSPaidMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }


    public function handle(EasySms $easySms)
    {
        $data = [
            'first' => '订单尚未支付，支付后开始检测(如已付款请忽略)',
            'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
            'keyword2' => ['value' => OrderEnum::getStatusName($this->order->status), 'color' => '#173177'],
            'keyword3' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
            'keyword4' => ['value' => $this->order->category->name, 'color' => '#173177'],
            'keyword5' => ['value' => $this->order->price, 'color' => '#173177'],
            'remark' => ['value' => '点击去支付', 'color' => '#173177']
        ];
        $touser = $this->order->user->weixin_openid;
        $template_id = config('wechat.official_account.templates.pending.template_id');
        $appid = config('wechat.official_account.templates.pending.appid');
        $pagepath = config('wechat.official_account.templates.pending.page_path');
        if($touser) {
            app('official_account')->template_message->send([
                'touser' => $touser,
                'template_id' => $template_id,
                'url' => 'https://m.checklike.com/p/report?phone=' . $this->order->phone,
//                'miniprogram' => [
//                    'appid' => $appid,
//                    'pagepath' => $pagepath,
//                ],
                'data' => $data,
            ]);
        }
        if($this->order->phone) {
            try {
                $result = $easySms->send($this->order->phone, [
                    'template' => config('easysms.gateways.aliyun.templates.ios_paiding'),
                    'data' => [
                        'phone' => $this->order->phone,
                    ]
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('aliyun')->getMessage();
                abort(500, $message ?: '短信发送异常!');
            }
        }
    }
}
