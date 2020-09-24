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

class OrderPendingMsg implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $host;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->host = request()->getHost();
    }


    public function handle()
    {
        if($this->order->status == 0) {
            $data = [
                'first' => '您有一个订单尚未完成支付，支付后开始检测',
                'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
                'keyword2' => ['value' => OrderEnum::getStatusName($this->order->status), 'color' => '#173177'],
                'keyword3' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
                'keyword4' => ['value' => $this->order->category->name, 'color' => '#173177'],
                'keyword5' => ['value' => $this->order->price, 'color' => '#173177'],
                'remark' => ['value' => '点击去支付', 'color' => '#173177']
            ];
            switch ($this->host) {
                case config('app.host.wf_host'):
                    $touser = $this->order->user->wf_weixin_openid;
                    $template_id = config('wechat.official_account.wf.templates.pending.template_id');
                    $appid = config('wechat.official_account.wf.templates.pending.appid');
                    $pagepath = config('wechat.official_account.wf.templates.pending.page_path');
                    $config = config('wechat.official_account.wf');
                    break;
                case config('app.host.wp_host'):
                    $touser = $this->order->user->wp_weixin_openid;
                    $template_id = config('wechat.official_account.wp.templates.pending.template_id');
                    $appid = config('wechat.official_account.wp.templates.pending.appid');
                    $pagepath = config('wechat.official_account.wp.templates.pending.page_path');
                    $config = config('wechat.official_account.wp');
                    break;
                default:
                    $touser = $this->order->user->dev_weixin_openid;
                    $template_id = config('wechat.official_account.dev.templates.pending.template_id');
                    $appid = config('wechat.official_account.dev.templates.pending.appid');
                    $pagepath = config('wechat.official_account.dev.templates.pending.page_path');
                    $config = config('wechat.official_account.dev');
            }
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
