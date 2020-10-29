<?php


namespace App\Handlers;


use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;

class FileWordsHandle
{
    protected $http;
    protected $uri;
    protected $username;
    protected $key;
    protected $productid;
    protected $sign;

    public function __construct(Client $client)
    {
        $this->http = $client;
        $this->uri = 'http://api.weipu.com/agent/api';
        $this->username = config('services.words_count.username');
        $this->key = config('services.words_count.key');
        $this->productid = 2;
    }

    public function submitCheck($file)
    {
        // 构建请求参数
        $query = [
            'multipart' => [
                [
                    'name' => 'productid',        //字段名
                    'contents' => $this->productid    //對應的值
                ],
                [
                    'name' => 'username',        //字段名
                    'contents' => $this->username    //對應的值
                ],
                [
                    'name' => 'sign',        //字段名
                    'contents' => md5($this->username . $this->productid . $this->key)     //對應的值
                ],
                [
                    'name' => 'file',        //文件字段名
                    'contents' => fopen($file, 'r') //文件資源
                ],
            ]
        ];

        $response = $this->http->post($this->uri . '/submit-check', $query);
        return json_decode($response->getbody()->getContents(), true);
    }

    public function queryParsing($orderid)
    {
        // 构建请求参数
        $query = [
            'multipart' => [
                [
                    'name' => 'username',        //字段名
                    'contents' => $this->username    //對應的值
                ],
                [
                    'name' => 'sign',        //字段名
                    'contents' => md5($this->username . $orderid . $this->key)     //對應的值
                ],
                [
                    'name' => 'orderid',        //文件字段名
                    'contents' => $orderid
                ],
            ]
        ];
        try {
            do {
                $response = $this->http->post($this->uri . '/query-parsing', $query);
                dd($response->getbody()->getContents());
            } while (!$response);
            return json_decode($response->getbody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        // 开始每个请求，但是不阻塞
//        $request = new Request('POST', );
//        $promise = $this->http->postAsync($this->uri . '/query-parsing', $query)->then(function($response) {
//            return json_decode($response->getbody()->getContents(), true);
//        });
//        $promise->wait();

    }
}
