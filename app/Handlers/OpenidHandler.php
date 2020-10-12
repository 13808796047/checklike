<?php


namespace App\Handlers;


use GuzzleHttp\Client;

class OpenidHandler
{
    protected $http;

    public function __construct()
    {
        // 实例化 HTTP 客户端
        $this->http = new Client();
    }

    public function getOpenid($code)
    {
        $config = config('wechat.official_account');
        $query = [
            'appid' => $config['app_id'],
            'secret' => $config['secret'],
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $response = $this->http->get(' https://api.weixin.qq.com/sns/oauth2/access_token', [$query]);
        return json_decode($response->getbody()->getContents());
    }

    public function openid($code)
    {
        $config = config('wechat.official_account');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $config['app_id'] . "&secret=" . $config['secret'] . "&code=" . $code . "&grant_type=authorization_code";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $content = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($status == 404) {
            return $status;
        }
        curl_close($ch);

        $array = get_object_vars(json_decode($content));//转换成数组
        return $array['openid'];//输出openid
    }
}
