<?php

namespace App\Http\Controllers;

use App\Exceptions\InvalidRequestException;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function index()
    {
        $word = search_word_from(URL::previous());
        if(!empty($word['from'])) {
            \Cache::put('word', $word, now()->addDay());
        }
        return view('pages.index');
    }

    public function loginCheck(Request $request)
    {
        // 判断请求是否有微信登录标识
        if(!$flag = $request->wechat_flag) {
            throw new InvalidRequestException('参数未传');
        }
        // 根据微信标识在缓存中获取需要登录用户的UID
        $uid = Cache::get('login_wechat' . $flag);
        $user = User::find($uid);
        if(!$user) {
            // 返回401
            throw new AuthenticationException('未登录');
        }
        // 登录用户,并清空缓存
        auth('web')->login($user);
        Cache::forget('login_wechat' . $flag);
        Cache::forget('qr_url' . $flag);
        return response('登录成功', 200);
    }
}
