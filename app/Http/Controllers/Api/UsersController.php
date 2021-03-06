<?php

namespace App\Http\Controllers\Api;

use App\Events\Invited;
use App\Events\RefreshPaged;
use App\Exceptions\InvalidRequestException;
use App\Http\Requests\Api\BoundPhoneRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\BindPhoneSuccess;
use App\Models\CouponCode;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(UserRequest $request)
    {
        if($verification_key = $request->verification_key) {
            $verifyData = \Cache::get($verification_key);
            if(!$verifyData) {
                abort(403, '验证码已失效');
            }
            if(!hash_equals($verifyData['code'], $request->verification_code)) {
                throw new AuthenticationException('验证码错误');
            }
            $phone = $verifyData['phone'];
        } else {
            $phone = $request->phone;
        }

        $user = User::create([
            'phone' => $phone,
            'password' => Hash::make($request->password),
        ]);
        \Cache::forget($verification_key);
        return new UserResource($user);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $this->authorize('update', $user);
        event(new RefreshPaged($user));
        return (new UserResource($user))->showSensitiveFields();
    }

    public function resetPassword(Request $request)
    {
        $user = $request->user();
    }

    public function boundPhone(BoundPhoneRequest $request)
    {
        $verification_key = $request->verification_key;
        if(!$verification_key) {
            throw new AuthenticationException('验证码错误!');
        }

        $verifyData = \Cache::get($verification_key);
        if(!$verifyData) {
            abort(403, '验证码已失效');
        }
        if(!hash_equals($verifyData['code'], $request->verification_code)) {
            throw new AuthenticationException('验证码错误');
        }
        $phone = $verifyData['phone'];
        $user = $this->userService->miniprogramBindPhone($request, $phone);
        $this->dispatch(new BindPhoneSuccess($user));
        \Cache::forget($verification_key);
        return response([
            'message' => '绑定成功!',
            'data' => $user
        ], 200);
    }

    public function officalBoundPhone(BoundPhoneRequest $request)
    {
        if(!$openid = $request->openid) {
            throw new AuthenticationException('参数错误!');
        }
        $verification_key = $request->verification_key;
        if(!$verification_key) {
            throw new AuthenticationException('验证码错误!');
        }

        $verifyData = \Cache::get($verification_key);
        if(!$verifyData) {
            abort(403, '验证码已失效');
        }
        if(!hash_equals($verifyData['code'], $request->verification_code)) {
            throw new AuthenticationException('验证码错误');
        }
        $phone = $verifyData['phone'];
        $this->userService->officalBindPhone($openid, $phone);
        \Cache::forget($verification_key);
        return response([
            'message' => '绑定成功!'
        ], 200);
    }

    // 邀请vip激活
    public function invite(Request $request)
    {
        // 微信登录
        try {
            if($code = $request->code) {
                $accessToken = $driver->getAccessToken($code);
            } else {
                $tokenData['access_token'] = $request->access_token;
                if($type == 'wechat') {
                    $tokenData['openid'] = $request->openid;
                }
                $accessToken = new AccessToken($tokenData);
            }
            $oauthUser = $driver->user($accessToken);
        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }
        $unionid = $oauthUser->getOriginal()['unionid'] ?? null;

        if($unionid) {
            $user = User::where('weixin_unionid', $unionid)->first();
        } else {
            $user = User::where('weixin_openid', $oauthUser->getId())->first();
        }
        // 没有用户，默认创建一个用户
        if(!$user) {
            $user = User::create([
                'nick_name' => $oauthUser->getNickname(),
                'avatar' => $oauthUser->getAvatar(),
                'weixin_openid' => $oauthUser->getId(),
                'weixin_unionid' => $unionid,
            ]);
            $user->increaseJcTimes(config('app.jc_times'));
        }
        $token = auth('api')->login($user);

        return response()->json([
            'access_token' => $token,
            'user' => (new UserResource($user))->showSensitiveFields(),
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL(),
        ])->setStatusCode(201);
    }

    public function active_vip(Request $request)
    {
        $user = $request->user();
        if(!config('invite_vip')) {
            throw new \Exception('无法激活');
        }
        if($user->vip_days > 31) {
            throw new InvalidRequestException('你已经激活过了');
        }
        $vip_expir_at = Carbon::parse($user->vip_expir_at)->addDays(31);
        $user->update([
            'user_group' => 3,
            'vip_expir_at' => $vip_expir_at,
        ]);
        $user->changeDays(31);
        return response()->json([
            'message' => '激活成功'
        ]);
    }
}
