<?php

namespace App\Http\Controllers;

use App\Jobs\SendLoginMessage;
use App\Jobs\Subscribed;
use App\Models\User;
use EasyWeChat\Factory;
use EasyWeChat\Kernel\Messages\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

class OfficialAccountController extends Controller
{
    protected $app;
    protected $prefix;

    public function __construct()
    {
        $this->app = app('official_account');
    }

    /**
     * 获取二维码图片
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // 查询cookie,如果没有就重新生成一次
        if(!$wechatFlag = $request->cookie('wechat_flag')) {
            $wechatFlag = Uuid::uuid4()->getHex();
        }
        // 缓存微信带参二维码
        if(!$url = Cache::get('qr_url' . $wechatFlag)) {
            // 有效期 1 天的二维码
            $qrCode = $this->app->qrcode;
            $result = $qrCode->temporary($wechatFlag, 3600 * 24);
            $url = $qrCode->url($result['ticket']);
            Cache::put('qr_url' . $wechatFlag, $url, now()->addDay());
        }
        // 自定义参参数返回前端
        return response(compact('url', 'wechatFlag'))
            ->cookie('wechat_flag', $wechatFlag, 24 * 60);
    }

    public function serve()
    {
        $this->app->server->push(function($message) {
            try {
                if($message) {
                    $method = \Str::camel('handle_' . $message['MsgType']);
                    if(method_exists($this, $method)) {
                        $this->openid = $message['FromUserName'];
                        $this->officialAccount = $message['ToUserName'];
                        return call_user_func_array([$this, $method], [$message]);
                    }
                }
                return "您好！欢迎使用论文检测服务";
            } catch (\Exception $e) {
            }

        });

        return $this->app->server->serve();
    }

    /**
     * 事件引导处理方法（事件有许多，拆分处理）
     *
     * @param $event
     *
     * @return mixed
     */
    protected function handleEvent($event)
    {
        $method = \Str::camel('event_' . $event['Event']);
        if(method_exists($this, $method)) {
            return call_user_func_array([$this, $method], [$event]);
        }
    }

    /**
     * 扫描带参二维码事件
     *
     * @param $event
     */
    public function eventSCAN($event)
    {
//        if(empty($event['EventKey'])) {
//            return;
//        }
//        $eventKey = $event['EventKey'];
//
//        $openId = $this->openid;
//        // 微信用户信息
//        $wxUser = $this->app->user->get($openId);
//        $user = User::where('weixin_unionid', $wxUser['unionid'])->first();
//        [$type, $id] = explode('-', $eventKey);
//        $loginUser = User::find($id);
//        $this->handleUser($type, $wxUser, $user, $loginUser);

        if($wxUser = User::where('weixin_openid', $this->openid)->first()) {
            // 标记前端可登录
            $this->markTheLogin($event, $wxUser->id);
            $this->afterLogin($wxUser);
            return;
        }
        $openId = $this->openid;
        // 微信用户信息
        $wxUser = $this->app->user->get($openId);
    }


    /**
     * 取消订阅
     *
     * @param $event
     */
    protected function eventUnsubscribe($event)
    {
        $wxUser = User::where('weixin_openid', $this->openid)->first();
        $wxUser->subscribe = 0;
        $wxUser->subscribe_time = null;
        $wxUser->save();
    }

    public function afterLogin(User $user)
    {
        $this->dispatch(new SendLoginMessage($user));
    }

    /**
     * 订阅
     *
     * @param $event
     *
     * @throws \Throwable
     */
    protected function eventSubscribe($event)
    {
        $openId = $this->openid;
//        if(empty($event['EventKey'])) {
//            return;
//        }
        // 关注事件的场景值会带一个前缀需要去掉
//        if($event['Event'] == 'subscribe') {
//            $eventKey = \Str::after($event['EventKey'], 'qrscene_');
//        }
//        // 微信用户信息
//        $wxUser = $this->app->user->get($openId);
//        //如果先授权登录,存在unionid
//        $user = User::where('weixin_unionid', $wxUser['unionid'])->first();
//
//        $loginUser = $user ?? new User();
//        if($eventKey) {
//            [$type, $id] = explode('-', $eventKey);
//            $loginUser = User::find($id);
//        }
//        // 注册
//        $this->handleUser($type ?? 'CC', $wxUser, $user, $loginUser);
//        if(!$loginUser->phone) {
//            $this->dispatch(new Subscribed($this->officialAccount, $loginUser));
//        }
        if($wxUser = User::where('weixin_openid', $this->openid)->first()) {
            // 标记可以登录
            $this->markTheLogin($event, $wxUser->id);
            $this->afterLogin($wxUser);
            return;
        }
        // 微信用户信息
        $wxUser = $this->app->user->get($openId);
        Log::info('wx', [$wxUser]);
        $this->makeTheUser($event, $wxUser);

    }


    public function makeTheUser($event, $wxUser)
    {
        // 注册
        $result = DB::transaction(function() use ($event, $wxUser) {
            // 用户
            $user = User::create([
                'nick_name' => $wxUser['nickname'],
                'avatar' => $wxUser['headimgurl'],
                'created_at' => now(),
                'subscribe' => $wxUser['subscribe'],
                'subscribe_time' => $wxUser['subscribe_time'],
                'weixin_openid' => $wxUser['openid'],
            ]);
            $this->markTheLogin($event, $user->id);
            $this->afterLogin($user);
        });
    }

    public function markTheLogin($event, $uid)
    {

        if(empty($event['EventKey'])) {
            return;
        }
        // 关注事件的场景值会带一个前缀需要去掉
        if($event['Event'] == 'subscribe') {
            $eventKey = \Str::after($event['EventKey'], 'qrscene_');
        } else {
            $eventKey = $event['EventKey'];
        }


        // 标记前端可登陆
        Cache::put('login_wechat' . $eventKey, $uid, now()->addMinute(30));
    }
//    public function handleUser($type, $wxUser, $user, &$loginUser)
//    {
//        if($type == 'JC') {
//            if(!$user) {
//                $invit_user->nick_name = $wxUser['nickname'];
//                $invit_user->avatar = $wxUser['headimgurl'];
//                $invit_user->weixin_unionid = $wxUser['unionid'];
//                switch ($this->officialAccount) {
//                    case 'gh_192a416dfc80':
//                        $invit_user->dev_weixin_openid = $wxUser['openid'];
//                        break;
//                    case 'gh_caf405e63bb3':
//                        $invit_user->wf_weixin_openid = $wxUser['openid'];
//                        break;
//                    case 'gh_1a157bde21a9':
//                        $invit_user->wp_weixin_openid = $wxUser['openid'];
//                        break;
//                    default:
//                        $invit_user->pp_weixin_openid = $wxUser['openid'];
//                }
//                $invit_user->save();
//                auth('web')->login($invit_user);
//                //邀请人
//                $loginUser->increaseJcTimes(5);
//                $invit_user->increaseJcTimes(5);
//            } else {
//                $message = new Text('您已经注册过账号了!');
//
//                $result = $this->app->customer_service->message($message)->to($invit_user->weixin_openid)->send();
//            }
//        }
//        if($type == 'CC') {
//            $loginUser->nick_name = $wxUser['nickname'];
//            $loginUser->avatar = $wxUser['headimgurl'];
//            $loginUser->weixin_unionid = $wxUser['unionid'];
//            switch ($this->officialAccount) {
//                case 'gh_192a416dfc80':
//                    $loginUser->dev_weixin_openid = $wxUser['openid'];
//                    break;
//                case 'gh_caf405e63bb3':
//                    $loginUser->wf_weixin_openid = $wxUser['openid'];
//                    break;
//                case 'gh_1a157bde21a9':
//                    $loginUser->wp_weixin_openid = $wxUser['openid'];
//                    break;
//                default:
//                    $loginUser->pp_weixin_openid = $wxUser['openid'];
//            }
//            $loginUser->save();
//        }
//        return $loginUser;
//    }
}
