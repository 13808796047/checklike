<?php


namespace App\Handlers;


use GuzzleHttp\Client;

class AiWriterHandler
{
    protected $http;

    public function __construct(Client $client)
    {
        $this->http = $client;
    }

    public function getContent($txt, $th, $filter, $corewordfilter, $sim, $retype, $type)
    {
        switch ($type) {
            case 'ai':
                $api = 'http://apis.5118.com/wyc/akey';
                $key = '20FED99DBE644B818379C20653A8806F';
                break;
            case 'rewrite':
                $api = 'http://apis.5118.com/wyc/rewrite';
                $key = '8A6473D0C0824E029E2C07AE453AC302';
                break;
        }
        dd($api, $key, $type);
        $data = [
            'txt' => $txt, //文件資源
            'th' => $th,
            'filter' => $filter,
            'corewordfilter' => $corewordfilter,
            'sim' => $sim,
            'retype' => $retype
        ];

        // 构建请求参数
        $option = [
            'headers' => [
                'Authorization' => $key,
                "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8"
            ],
            'form_params' => $data,
        ];

        $response = $this->http->post($api, $option);
//        dd($response->getbody()->getContents());
        return $response->getbody()->getContents();
//        $host = "http://apis.5118.com";
//        $path = "/wyc/akey";
//        $method = "POST";
//        $apikey = "20FED99DBE644B818379C20653A8806F";
//        $headers = [];
//        array_push($headers, "Authorization:" . $apikey);
//        //根据API的要求，定义相对应的Content-Type
//        array_push($headers, "Content-Type" . ":" . "application/x-www-form-urlencoded; charset=UTF-8");
//        array_push($headers, "Content-Type" . ":" . "application/json; charset=UTF-8");
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
//            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
//            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
//        }
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
//        $output = curl_exec($curl);
//        curl_close($curl);
//        return $output;
    }
}
