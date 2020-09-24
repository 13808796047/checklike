<?php


namespace App\Handlers;


use GuzzleHttp\Client;

class AiWriterHandler
{
    protected $api;
    protected $token;

    public function __construct()
    {
        $this->http = new Client;
        $api_list = [
            'http://aiapi.ruanwenyuan.com',
            'http://aiapi2.ruanwenyuan.com',
        ];
        $random_keys = array_rand($api_list, 1);
        $this->api = $api_list[$random_keys] . '/api/creation';
        $this->token = '$2y$10$K8gSIdvi2tpyJ94OZ/iKUOIFWZj2aKhjxTYddndl8tMNb5mvjr60G';
    }

    public function getContent($content)
    {
        $array = [
            'form_params' => [
                'token' => $this->token,
                'content' => $content
            ]
        ];
        $response = $this->http->request("POST", $this->api, $array);
        return json_decode($response->getBody(), true);
    }
}
