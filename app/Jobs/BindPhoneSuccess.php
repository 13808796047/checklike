<?php

namespace App\Jobs;

use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BindPhoneSuccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'first' => '您已成功绑定手机号',
            'keyword1' => ['value' => $this->user->phone, 'color' => '#173177'],
            'keyword2' => ['value' => '已绑定', 'color' => '#173177'],
            'remark' => ['value' => '感谢您的使用', 'color' => '#173177']
        ];
        $template_id = config('wechat.official_account.templates.binded.template_id');
        $appid = config('wechat.official_account.templates.binded.appid');
        $pagepath = config('wechat.official_account.templates.binded.page_path');

        $touser = $this->user->weixin_openid;
        if($touser) {
            app('official_account')->template_message->send([
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
