<?php


namespace App\Handlers;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class FileWordsHandle
{
    public function getWords($title, $author, $file)
    {
        // 实例化 HTTP 客户端
        $http = new Client();
        // 初始化配置信息
        $api = 'http://121.40.155.95:8090/agent/api/uploadToCount.html';
        $appid = config('services.words_count.appid');
        $key = config('services.words_count.key');
        $sign = md5($appid . $key);
        // 构建请求参数
        $query = [
            'multipart' => [
                [
                    'name' => 'productid',        //字段名
                    'contents' => 2    //對應的值
                ],
                [
                    'name' => 'title',        //字段名
                    'contents' => $title    //對應的值
                ],
                [
                    'name' => 'author',        //字段名
                    'contents' => $author    //對應的值
                ],
                [
                    'name' => 'username',        //字段名
                    'contents' => 'lianwen'    //對應的值
                ],
                [
                    'name' => 'sign',        //字段名
                    'contents' => $sign     //對應的值
                ],
                [
                    'name' => 'orderId',        //字段名
                    'contents' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT),  //對應的值
                ],
                [
                    'name' => 'file',        //文件字段名
                    'contents' => fopen($file, 'r') //文件資源
                ],
            ]
        ];

        $response = $http->post($api, $query);
        return json_decode($response->getbody()->getContents(), true);
    }
}
