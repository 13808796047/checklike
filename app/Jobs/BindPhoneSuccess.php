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

    protected $host;
    protected $user;

    public function __construct(User $user)
    {
        $this->host = request()->getHost();
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
        switch ($this->host) {
            case config('app.host.wf_host'):
                $touser = $this->user->wf_weixin_openid;
                $template_id = config('wechat.official_account.wf.templates.binded.template_id');
                $appid = config('wechat.official_account.wf.templates.binded.appid');
                $pagepath = config('wechat.official_account.wf.templates.binded.page_path');
                $config = config('wechat.official_account.wf');
                break;
            case config('app.host.wp_host'):
                $touser = $this->user->wp_weixin_openid;
                $template_id = config('wechat.official_account.wp.templates.binded.template_id');
                $appid = config('wechat.official_account.wp.templates.binded.appid');
                $pagepath = config('wechat.official_account.wp.templates.binded.page_path');
                $config = config('wechat.official_account.wp');
                break;
            default:
                $touser = $this->user->dev_weixin_openid;
                $template_id = config('wechat.official_account.dev.templates.binded.template_id');
                $appid = config('wechat.official_account.dev.templates.binded.appid');
                $pagepath = config('wechat.official_account.dev.templates.binded.page_path');
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
