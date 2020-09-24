<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\BoundPhoneRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\BindPhoneSuccess;
use App\Models\User;
use App\Services\UserService;
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
        return (new UserResource($request->user))->showSensitiveFields();
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
}
