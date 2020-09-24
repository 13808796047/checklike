<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Overtrue\EasySms\EasySms;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request, EasySms $easySms)
    {
        $phone = $request->phone;
        if(!app()->environment('production')) {
            $code = '1234';
        } else {
            //生成4位随机数,左侧补0
            $code = str_pad(random_int(1, 9999), 4, 0, STR_PAD_LEFT);
        }
        $data = [
            'code' => $code,
        ];
        $domain = request()->getHost();
        switch ($domain) {
            case config('app.host.wf_host'):
                $data['product'] = '万方查重';
                break;
            case config('app.host.wp_host'):
                $data['product'] = '维普查重';
                break;
            case config('app.host.pp_host'):
                $data['product'] = 'paperPass检测';
                break;
            default:
                $data['product'] = '学信检测';
        }
        try {
            $result = $easySms->send($phone, [
                'template' => config('easysms.gateways.aliyun.templates.register'),
                'data' => $data
            ]);
        } catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $exception) {
            $message = $exception->getException('aliyun')->getMessage();
            abort(500, $message ?: '短信发送异常!');
        }
        $key = 'verificationCode_' . \Str::random(15);
        $expiredAt = now()->addMinutes(5);
        //缓存验证码5分钟过期
        \Cache::put($key, ['phone' => $phone, 'code' => $code], $expiredAt);
        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ])->setStatusCode(201);
    }
}
