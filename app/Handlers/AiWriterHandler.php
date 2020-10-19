<?php


namespace App\Handlers;


use GuzzleHttp\Client;

class AiWriterHandler
{
    protected $api;
    protected $token;

    public function __construct(Client $client)
    {
        $this->http = $client;
        $this->api = 'http://apis.5118.com/wyc/akey';
//        $this->token = '$2y$10$K8gSIdvi2tpyJ94OZ/iKUOIFWZj2aKhjxTYddndl8tMNb5mvjr60G';
    }

    public function getContent($content)
    {
        $array = [
            'form_params' => [
                'content' => $content
            ]
        ];
        $response = $this->http->request("POST", $this->api, $array);
        return json_decode($response->getBody(), true);
    }
}
