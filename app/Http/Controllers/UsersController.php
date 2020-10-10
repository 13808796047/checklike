<?php

namespace App\Http\Controllers;

use App\Jobs\BindPhoneSuccess;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function boundPhone(Request $request)
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
        $user = $request->user();
        $user->update([
            'phone' => $phone
        ]);
        $this->dispatch(new BindPhoneSuccess($user));
        if($request->wantsJson()) {
            return response()->json([
                'message' => '绑定成功!'
            ]);
        }
        return redirect($this->redirectPath())
            ->with('status', '绑定成功');
    }

    public function resetPassword(Request $request)
    {
        $user = $request->user();
        $password = $request->password;
        $this->setUserPassword($user, $password);
        $this->guard()->login($user);
        if($request->wantsJson()) {
            return new JsonResponse(['message' => '修改成功'], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', '修改成功');
    }

    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function sendResetResponse(Request $request, $response)
    {
        if($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }
}
