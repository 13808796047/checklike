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
        Log::info('发送', $this->user->weixin_openid);
        if(!$touser = $this->user->weixin_openid) {
            return;
        }
        $data = [
            'first' => '您已成功登录',
            'keyword1' => ['value' => Carbon::now()],
            'keyword2' => ['value' => '登录成功'],
            'keyword3' => ['value' => 'www.checklike.com'],
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
