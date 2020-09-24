<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\InvalidRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MiniProgromAuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use function Composer\Autoload\includeFile;

class AuthorizationsController extends Controller
{
    //微信登录
    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        $driver = \Socialite::driver($type);
        try {
            if($code = $request->code) {
                $response = $driver->getAccessTokenResponse($code);
                $token = Arr::get($response, 'access_token');
            } else {
                $token = $request->access_token;
                if($type == 'weixin') {
                    $driver->setOpenId($request->request->openid);
                }
            }
            $oauthUser = $driver->userFromToken($token);
        } catch (\Exception $e) {
            throw new AuthenticationException('参数错误，未获取用户信息');
        }
        switch ($type) {
            case 'weixin':
                $unionid = $oauthUser->offsetExists('unionid') ? $oauthUser->offsetGet('unionid') : null;

                if($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if(!$user) {
                    $user = User::create([
                        'name' => $oauthUser->getNickname(),
                        'avatar' => $oauthUser->getAvatar(),
                        'weixin_openid' => $oauthUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }
        $token = auth('api')->login($user);

        return $this->respondWithToken($token)->setStatusCode(201);
    }

    //微信小程序登录
    public function miniProgramStore(MiniProgromAuthorizationRequest $request)
    {
        $domain = request()->getHost();
        switch ($domain) {
            case config('app.host.dev_host'):
                $config = config('wechat.mini_program.dev');
                $this->uri = 'dev';
                break;
            case config('app.host.wf_host'):
                $config = config('wechat.mini_program.wf');
                $this->uri = 'wf';
                break;
            case config('app.host.wp_host'):
                $config = config('wechat.mini_program.wp');
                $this->uri = 'wp';
                break;
            case config('app.host.pp_host'):
                $config = config('wechat.mini_program.pp');
                $this->uri = 'pp';
                break;
            default:
                $config = config('wechat.mini_program.cn');
                $this->uri = 'cn';
        }
        $app = Factory::miniProgram($config);
        if(!$code = $request->code) {
            throw new AuthenticationException('参数code错误，未获取用户信息');
        }
        $data = $app->auth->session($code);
        if($iv = $request->iv) {
            $encryptData = $request->encryptData;
            $decryptedData = $app->encryptor->decryptData($data['session_key'], $iv, $encryptData);
            $data['unionid'] = $decryptedData['unionId'];
        }

        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if(isset($data['errcode'])) {
            throw new AuthenticationException('code 不正确');
        }
        // 找到 openid 对应的用户
        $user = User::where('weixin_unionid', $data['unionid'])->first();
        $attributes['weixin_session_key'] = $data['session_key'];
        switch ($this->uri) {
            case 'dev':
                $attributes['dev_weapp_openid'] = $data['openid'];
                break;
            case 'wf':
                $attributes['wf_weapp_openid'] = $data['openid'];
                break;
            case 'wp':
                $attributes['wp_weapp_openid'] = $data['openid'];
                break;
            case 'pp':
                $attributes['pp_weapp_openid'] = $data['openid'];
                break;
            default:
                $attributes['cn_weapp_openid'] = $data['openid'];
        }
        $attributes['weixin_unionid'] = $data['unionid'];
        if(!$user) {
            $user = User::create($attributes);
            $user->increaseJcTimes(2);
        } else {
            $user->update($attributes);
        }
//        if($user->weapp_openid == '') {
//            $user->update([
//                'weapp_openid' => $data['openid'],
//            ]);
//        }
        $token = auth('api')->login($user);
        return response()->json([
            'access_token' => $token,
            'user' => (new UserResource($user))->showSensitiveFields(),
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL(),
        ])->setStatusCode(201);
    }

    public function store(Request $request)
    {
        if($request->type == 'phone') {
            $this->validate($request, [
                'verification_key' => 'required|string',
                'verification_code' => 'required|string',
            ], [], [
                'verification_key' => '短信验证码 key',
                'verification_code' => '短信验证码',
            ]);
            $verifyData = \Cache::get($request->verification_key);
            if(!$verifyData) {
                abort(403, '验证码已失效');
            }
            if(!hash_equals($verifyData['code'], $request->verification_code)) {
                // 返回401
                throw new AuthenticationException('验证码错误');
            }
            $user = User::where('phone', $verifyData['phone'])->first();
            if(!$user) {
                $user = User::create([
                    'phone' => $verifyData['phone']
                ]);
                $user->increaseJcTimes(2);
            }
            $token = auth('api')->login($user);
            // 清除验证码缓存
            \Cache::forget($request->verification_key);
        } else {
            $this->validate($request, [
                'phone' => [
                    'required',
                    'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/',
                ],
                'password' => 'required|alpha_dash|min:6',
            ], [], [
                'phone' => '手机号码',
                'password' => '密码'
            ]);
            $credentials['phone'] = $request->phone;
            $credentials['password'] = $request->password;
            if(!$token = \Auth::guard('api')->attempt($credentials)) {
                return response()->json(['error' => '未登录或登录状态失效'], 401);
            }
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL(),
        ])->setStatusCode(201);
    }

    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }

    //刷新Token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL(),
        ]);
    }
}
