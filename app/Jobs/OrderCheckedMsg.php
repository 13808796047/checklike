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
use Overtrue\EasySms\EasySms;

class OrderCheckedMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle()
    {
        $data = [
            'first' => '您的论文已经检测完成,点击查看结果',
            'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
            'keyword2' => ['value' => $this->order->category->name, 'color' => '#173177'],
            'keyword3' => ['value' => $this->order->rate . '%', 'color' => '#173177'],
            'keyword4' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
            'remark' => ['value' => '点击查看详情！', 'color' => '#173177']
        ];
        $touser = $this->order->user->weixin_openid;
        if($touser) {
            app('official_account')->template_message->send([
                'touser' => $touser,
                'template_id' => config('wechat.official_account.templates.checked.template_id'),
//                'url' => 'https://wap.lianwen.com/bading?openid=' . $this->order->user->weixin_openid,
                'miniprogram' => [
                    'appid' => config('wechat.official_account.templates.checked.appid'),
                    'pagepath' => config('wechat.official_account.templates.checked.page_path'),
                ],
                'data' => $data,
            ]);
        } else {
            try {
                $result = app('easysms')->send($this->order->user->phone, [
                    'template' => config('easysms.gateways.aliyun.templates.checked'),
                ]);
            } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
                $message = $exception->getException('aliyun')->getMessage();
                abort(500, $message ?: '短信发送异常!');
            }
        }

    }
}
