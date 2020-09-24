<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Exception\InvalidArgumentException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Overtrue\Socialite\SocialiteManager;

class AuthenticationsController extends Controller
{
    protected $app;
    protected $uri;

    public function __construct()
    {
        $host = \request()->getHost();
        switch ($host) {
            case config('app.host.dev_host'):
                $config = config('services.dev_lianwen_com');
                $this->uri = 'dev';
                break;
            case config('app.host.wf_host'):
                $config = config('services.wanfang_lianwen_com');
                $this->uri = 'wf';
                break;
            case config('app.host.wp_host'):
                $config = config('services.weipu_lianwen_com');
                $this->uri = 'wp';
                break;
            case config('app.host.cn_host'):
                $config = config('services.www_cnweipu_com');
                $this->uri = 'cn';
                break;
            default:
                $config = config('services.pp_lianwen_com');
        }
        $this->app = new SocialiteManager($config);
    }

    public function oauth($type, Request $request)
    {
        if($request->has('uid')) {
            \Cache::put('uid', $request->uid, now()->addDay());
        }
        return $this->app->driver($type)->redirect();
    }

    public function callback($type, Request $request)
    {
        try {
            $oauthUser = $this->app->driver($type)->user();
        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }
        switch ($type) {
            case 'wechat':
                $unionid = $oauthUser->getOriginal()['unionid'] ?: null;
                if($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where($this->openid, $oauthUser->getOriginal()['openid'])->first();
                }
                // 没有用户，默认创建一个用户
                if(!$user) {
                    $attributes = [
                        'nick_name' => $oauthUser['nickname'],
                        'avatar' => $oauthUser['avatar'],
                        'weixin_unionid' => $unionid,
                    ];
                    switch ($this->uri) {
                        case 'dev':
                            $attributes['dev_weixin_openid'] = $oauthUser->getOriginal()['openid'];
                            break;
                        case 'wf':
                            $attributes['wf_weixin_openid'] = $oauthUser->getOriginal()['openid'];
                            break;
                        case 'wp':
                            $attributes['wp_weixin_openid'] = $oauthUser->getOriginal()['openid'];
                            break;
                        case 'cn':
                            $attributes['cn_weixin_openid'] = $oauthUser->getOriginal()['openid'];
                            break;
                    }
                    $user = User::create($attributes);
                    $uid = \Cache::get('uid');
                    //邀请人
                    if($uid) {
                        $inviter = User::findOrFail($uid);
                        $inviter->increaseJcTimes(5);
                        $user->increaseJcTimes(5);
                        \Cache::forget('uid');
                    }
                    $user->increaseJcTimes(2);

                }

                break;
        }
        auth('web')->login($user);
        return redirect()->to('/');
    }

//    public function accountLogin(Request $request)
//    {
//        $credentials = $this->validate($request, [
//            'phone' => 'required|unique:users|max:50',
//            'password' => 'required|confirmed|min:6'
//        ]);
//        $credentials['phone'] = $request->phone;
//        $credentials['password'] = $request->password;
//        if(\Auth::attempt($credentials)) {
//            session()->flash('success', '欢迎回来！');
//            return redirect()->route('pages.index');
//        } else {
//            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
//            return redirect()->back()->withInput();
//        }
//    }
//
//    public function mobileLogin(Request $request)
//    {
//        $validatedData = $request->validate([
//            'phone' => 'required|unique:users|max:50',
//            'verification_key' => 'required',
//            'verification_code' => 'required',
//        ]);
//
//        $verifyData = \Cache::get($request->verification_key);
//        if(!$verifyData) {
//            abort(403, '验证码已失效');
//        }
//        if(!hash_equals($verifyData['code'], $request->verification_code)) {
//            // 返回401
//            throw new AuthenticationException('验证码错误');
//        }
//        $phone = $verifyData['phone'];
//
//    }
}
