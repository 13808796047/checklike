<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    public function showLoginForm()
    {
        return view('domained::pages.index');
    }

    public function username()
    {
        return 'phone';
    }

    public function login(Request $request)
    {
        if($request->type == 'account') {
            $this->validate($request, [
                $this->username() => 'required|string',
                'password' => 'required|string',
            ], [], [
                $this->username() => '手机号',
            ]);
            if($this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            )) {
                return response()->json([
                    'message' => '登录成功!'
                ]);
            } else {
                return response()->json([
                    'error' => '您的账号密码错误!'
                ], 401);
            }
        } else {
            $this->validate($request, [
                $this->username() => 'required|string',
                'verification_key' => 'required|string',
                'verification_code' => 'required|string',
            ], [], [
                $this->username() => '手机号',
                'verification_key' => '短信Key',
                'verification_code' => '短信验证码',
            ]);
            if($verification_key = $request->verification_key) {
                $verifyData = \Cache::get($verification_key);
                if(!$verifyData) {
                    abort(403, '验证码已失效');
                }
                if(!hash_equals($verifyData['code'], $request->verification_code)) {
                    // 返回401
                    throw new AuthenticationException('验证码错误');
                }
                $phone = $verifyData['phone'];

                $user = User::where('phone', $phone)->first();
                if(!$user) {
                    $user = User::create([
                        'phone' => $phone,
                    ]);
                    // 清除验证码缓存
//                    return response()->json([
//                        'message' => '用户不存在!'
//                    ], 401);
                }
                // 清除验证码缓存
                \Cache::forget($verification_key);
                return $this->guard()->login($user);
            }

        }
    }
//    protected function validateLogin(Request $request)
//    {
//        if($request->type == 'account') {
//            $this->validate($request, [
//                $this->username() => 'required|string',
//                'password' => 'required|string',
//            ], [], [
//                $this->username() => '手机号',
//            ]);
//        } else {
//            $this->validate($request, [
//                $this->username() => 'required|string',
//                'verification_key' => 'required|string',
//                'verification_code' => 'required|string',
//            ], [], [
//                $this->username() => '手机号',
//                'verification_key' => '短信Key',
//                'verification_code' => '短信验证码',
//            ]);
//        }
//    }

    protected function attemptLogin(Request $request)
    {
        if($verification_key = $request->verification_key) {
            $verifyData = \Cache::get($verification_key);
            if(!$verifyData) {
                abort(403, '验证码已失效');
            }
            if(!hash_equals($verifyData['code'], $request->verification_code)) {
                // 返回401
                throw new AuthenticationException('验证码错误');
            }
            $phone = $verifyData['phone'];
            $user = User::where('phone', $phone)->first();
            if(!$user) {
                return response()->json([
                    'message' => '用户不存在!'
                ], 401);
            }
            $this->guard()->login($user);
        } else {
            return $this->guard()->attempt(
                $this->credentials($request), $request->filled('remember')
            );
        }
    }
//    protected function attemptLogin(Request $request)
    //    {
    //        return collect(['username', 'phone'])->contains(function($value) use ($request) {
    //            $account = $request->get($this->username());
    //            $password = $request->get('password');
    //            return $this->guard()->attempt([$value => $account, 'password' => $password], $request->filled('remember'));
    //        });
    //    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
