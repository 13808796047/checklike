<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendLoginMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function handle()
    {
        if(!$touser = $this->user->weixin_openid) {
            return;
        }
        $data = [
            'first' => '您已成功登录',
            'keyword1' => ['value' => Carbon::now()->format('Y-m-d H:i:s')],
            'keyword2' => ['value' => '登录成功'],
            'keyword3' => ['value' => config('app.ios_host')],
            'remark' => ['value' => '点击使用小程序', 'color' => '#173177']
        ];

        $template_id = config('wechat.official_account.templates.logined.template_id');
        $appid = config('wechat.official_account.templates.logined.appid');
        $pagepath = config('wechat.official_account.templates.logined.page_path');
        $config = config('wechat.official_account');

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
