<?php

namespace App\Http\Controllers;

use App\Jobs\BindPhoneSuccess;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        // 公众号用户
        $user = $request->user();
        // 手机用户
        $phoneUser = User::where('phone', $phone)->first();
        if(!$phoneUser) {
            $user->update([
                'phone' => $phone
            ]);
        } else {
            $user = DB::transaction(function() use ($user, $phoneUser, $phone) {
                DB::table('orders')->where('userid', $phoneUser->id)->update([
                    'userid' => $user->id
                ]);
                $phoneUser->delete();
                $user->update([
                    'phone' => $phone,
                    'password' => $phoneUser->password ?? "",
                ]);
                return $user;
            });
        }

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

    public function show(User $user)
    {
        $this->authorize('update', $user);
        return view('users.show', compact('user'));
    }

}
