<?php


namespace App\Handlers;


use GuzzleHttp\Client;
use function EasyWeChat\Kernel\Support\str_random;

class AutoCheckHandler
{
    protected $http;
    protected $api;
    protected $appid;
    protected $key;
    protected $sign;
    protected $salt;

    public function __construct()
    {
        $this->http = new Client;
        $this->api = 'http://api.fanyi.baidu.com/api/trans/vip/translate';
//        $config_arr = ['baidu_translate_one', 'baidu_translate_two', 'baidu_translate_tree', 'baidu_translate_four'];
        $config = random_int(1, 4);
        $this->appid = config('services.baidu_translate_' . $config . '.appid');
        $this->key = config('services.baidu_translate_' . $config . '.key');
        //根据文档生成sign
        $this->salt = time();
    }

    public function translate_en($text)
    {
        $sign = md5($this->appid . $text . $this->salt . $this->key);

        $array = [
            'form_params' => [
                'q' => $text,
                "from" => 'zh',
                "to" => "en",
                "appid" => $this->appid,
                "salt" => $this->salt,
                "sign" => $sign
            ]
        ];
        $response = $this->http->request("POST", $this->api, $array);
        return json_decode($response->getBody(), true);
    }

    public function translate_cn($text)
    {
        $sign = md5($this->appid . $text . $this->salt . $this->key);
        $array = [
            'form_params' => [
                'q' => $text,
                "from" => 'en',
                "to" => "zh",
                "appid" => $this->appid,
                "salt" => $this->salt,
                "sign" => $sign
            ]
        ];
        $response = $this->http->request("POST", $this->api, $array);
        return json_decode($response->getBody(), true);
    }
}
