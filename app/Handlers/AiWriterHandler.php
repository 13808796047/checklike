<?php


namespace App\Handlers;


use GuzzleHttp\Client;

class AiWriterHandler
{
    protected $api;
    protected $http;

    public function __construct(Client $client)
    {
        $this->api = 'http://apis.5118.com/wyc/akey';
        $this->http = $client;
    }

    public function getContent($content)
    {
        $data = [
            'txt' => $content, //文件資源
        ];

        // 构建请求参数
        $option = [
            'headers' => [
                'Authorization' => '20FED99DBE644B818379C20653A8806F',
                "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8"
            ],
            'body' => $data,
        ];
        $response = $this->http->post($this->api, $option);
        dd($response->getbody()->getContents());
        return json_decode($response->getbody()->getContents());
//        $host = "http://apis.5118.com";
//        $path = "/wyc/akey";
//        $method = "POST";
//        $apikey = "20FED99DBE644B818379C20653A8806F";
//        $headers = [];
//        array_push($headers, "Authorization:" . $apikey);
//        //根据API的要求，定义相对应的Content-Type
//        array_push($headers, "Content-Type" . ":" . "application/x-www-form-urlencoded; charset=UTF-8");
//        $querys = "";
//        $bodys = "txt={$content}&th=th&filter=filter&corewordfilter=corewordfilter";
//        $url = $host . $path;
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($curl, CURLOPT_FAILONERROR, false);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_HEADER, true);
//        if(1 == strpos("$" . $host, "https://")) {
//            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//        }
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
//        $output = curl_exec($curl);
//        curl_close($curl);
//        return $output;
    }
}
