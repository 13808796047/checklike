<?php

namespace App\Http\Controllers\Api;

use App\Events\RefreshPaged;
use App\Exceptions\InternalException;
use App\Exceptions\InvalidRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MiniProgromAuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use EasyWeChat\Factory;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Overtrue\Socialite\SocialiteManager;
use Yansongda\Supports\Log;


class AuthorizationsController extends Controller
{
    //微信登录
    public function socialStore($type, SocialAuthorizationRequest $request)
    {
        $driver = \Socialite::driver($type);
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
        switch ($type) {
            case 'wechat':
                $unionid = $oauthUser['original']['unionid'] ?? null;

                if($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $oauthUser['id'])->first();
                }
                $attributes ['avatar'] = $oauthUser['avatar'];
                $attributes ['nick_name'] = $oauthUser['nickname'];
                $attributes['weapp_openid'] = $oauthUser['id'];
                $attributes['weixin_unionid'] = $unionid;
                // 没有用户，默认创建一个用户
                if(!$user) {
                    $user = User::create($attributes);
                    $user->increaseJcTimes(config('app.jc_times'));
                }
                $user->update($attributes);
                break;
        }
        $token = auth('api')->login($user);

        return response()->json([
            'access_token' => $token,
            'user' => (new UserResource($user))->showSensitiveFields(),
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL(),
        ])->setStatusCode(201);
    }


    public function baiduMiniProgramStore(Request $request)
    {

        if(!$code = $request->code) {
            throw new AuthenticationException('参数code错误，未获取用户信息');
        }
        $url = 'https://spapi.baidu.com/oauth/jscode2sessionkey';
        switch ($request->type) {
            case 1:
                $client_id = config('services.baidu_weapp_1.client_id');
                $sk = config('services.baidu_weapp_1.client_secret');
                break;
            case 2:
                $client_id = config('services.baidu_weapp_2.client_id');
                $sk = config('services.baidu_weapp_2.client_secret');
                break;
            case 3:
                $client_id = config('services.baidu_weapp_3.client_id');
                $sk = config('services.baidu_weapp_3.client_secret');
                break;
            case 4:
                $client_id = config('services.baidu_weapp_4.client_id');
                $sk = config('services.baidu_weapp_4.client_secret');
                break;
            case 5:
                $client_id = config('services.baidu_weapp_5.client_id');
                $sk = config('services.baidu_weapp_5.client_secret');
                break;
            case 6:
                $client_id = config('services.baidu_weapp_6.client_id');
                $sk = config('services.baidu_weapp_6.client_secret');
                break;

        }
        $data = [
            "code" => $code,
            "client_id" => $client_id,
            "sk" => $sk
        ];
        $ret = $this->curlPost($url, $data);
        if(!$ret['session_key']) {
            throw new AuthenticationException('会话过期,请重新登录');
        }
        if($iv = $request->iv) {
            $encryptData = $request->encryptData;
            $decryptedData = $this->decrypt($encryptData, $iv, $client_id, $ret['session_key']);
        }
        $user = User::where('phone', $decryptedData['mobile'])->first();
        \Log::info('xxxx', $user);
        if(!$user) {
            $user = User::create([
                'phone' => $decryptedData['mobile'],
                'username' => 'bd' . $decryptedData['mobile']
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

    public function decrypt($ciphertext, $iv, $app_key, $session_key)
    {
        $session_key = base64_decode($session_key);
        $iv = base64_decode($iv);
        $ciphertext = base64_decode($ciphertext);

        $plaintext = false;
        if(function_exists("openssl_decrypt")) {
            $plaintext = openssl_decrypt($ciphertext, "AES-192-CBC", $session_key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
        } else {
            $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, null, MCRYPT_MODE_CBC, null);
            mcrypt_generic_init($td, $session_key, $iv);
            $plaintext = mdecrypt_generic($td, $ciphertext);
            mcrypt_generic_deinit($td);
            mcrypt_module_close($td);
        }
        if($plaintext == false) {
            return false;
        }

        // trim pkcs#7 padding
        $pad = ord(substr($plaintext, -1));
        $pad = ($pad < 1 || $pad > 32) ? 0 : $pad;
        $plaintext = substr($plaintext, 0, strlen($plaintext) - $pad);

        // trim header
        $plaintext = substr($plaintext, 16);
        // get content length
        $unpack = unpack("Nlen/", substr($plaintext, 0, 4));
        // get content
        $content = substr($plaintext, 4, $unpack['len']);
        // get app_key
        $app_key_decode = substr($plaintext, $unpack['len'] + 4);

        return $app_key == $app_key_decode ? json_decode($content, true) : false;
    }

    public function curlPost($url, $postDataArr)
    {

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataArr);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return json_decode($output, true);
    }

    //微信小程序登录
    public function miniProgramStore(MiniProgromAuthorizationRequest $request)
    {
        $app = Factory::miniProgram(config('wechat.mini_program'));
        if(!$code = $request->code) {
            throw new AuthenticationException('参数code错误，未获取用户信息');
        }
        $result = $app->auth->session($code);
        if($iv = $request->iv) {
            $encryptData = $request->encryptData;
            $decryptedData = $app->encryptor->decryptData($result['session_key'], $iv, $encryptData);
        }

        // 如果结果错误，说明 code 已过期或不正确，返回 401 错误
        if(isset($decryptedData['errcode'])) {
            throw new AuthenticationException('code 不正确');
        }
        $user = User::where('weixin_unionid', $decryptedData['unionId'])->first();
        $attributes['weixin_session_key'] = $result['session_key'];
        $attributes ['avatar'] = $decryptedData['avatarUrl'];
        $attributes ['nickname'] = $decryptedData['nickName'];
        $attributes['weapp_openid'] = $decryptedData['openId'];
        $attributes['weixin_unionid'] = $decryptedData['unionId'];
        if(!$user) {
            $user = User::create($attributes);
            $user->increaseJcTimes(config('app.jc_times'));
        }
        $user->update($attributes);

        $token = auth('api')->login($user);
        return response()->json([
            'access_token' => $token,
            'user' => (new UserResource($user))->showSensitiveFields(),
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL(),
        ])->setStatusCode(201);
    }

    public function checkPhone(Request $request)
    {
        $result = User::where('phone', $request->phone)->exists();
        if($result) {
            return response()->json(['message' => '手机号已经存在'], 401);
        }
        return response()->json(['message' => '手机号可以使用'], 200);
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
                $user->increaseJcTimes(config('app.jc_times'));
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
