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

class OrderCheckedMsg implements ShouldQueue
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
        if($this->order->status == 4) {
            $data = [
                'first' => '您的论文已经检测完成,点击查看结果',
                'keyword1' => ['value' => $this->order->title, 'color' => '#173177'],
                'keyword2' => ['value' => $this->order->category->name, 'color' => '#173177'],
                'keyword3' => ['value' => $this->order->rate, 'color' => '#173177'],
                'keyword4' => ['value' => $this->order->created_at->format("Y-m-d H:i:s"), 'color' => '#173177'],
                'remark' => ['value' => '点击查看详情！', 'color' => '#173177']
            ];
            [$class, $type] = explode('-', $this->order->from);
            switch ($class) {
                case 'wf':
                    $touser = $this->order->user->wf_weixin_openid;
                    $template_id = config('wechat.official_account.wf.templates.checked.template_id');
                    $appid = config('wechat.official_account.wf.templates.checked.appid');
                    $pagepath = config('wechat.official_account.wf.templates.checked.page_path');
                    $config = config('wechat.official_account.wf');
                    break;
                case 'wp':
                    $touser = $this->order->user->wp_weixin_openid;
                    $template_id = config('wechat.official_account.wp.templates.checked.template_id');
                    $appid = config('wechat.official_account.wp.templates.checked.appid');
                    $pagepath = config('wechat.official_account.wp.templates.checked.page_path');
                    $config = config('wechat.official_account.wp');
                    break;
                default:
                    $touser = $this->order->user->dev_weixin_openid;
                    $template_id = config('wechat.official_account.dev.templates.checked.template_id');
                    $appid = config('wechat.official_account.dev.templates.checked.appid');
                    $pagepath = config('wechat.official_account.dev.templates.checked.page_path');
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
