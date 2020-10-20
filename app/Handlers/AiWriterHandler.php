<?php


namespace App\Handlers;


class AiWriterHandler
{
    public function getContent($content)
    {
        $host = "http://apis.5118.com";
        $path = "/wyc/akey";
        $method = "POST";
        $apikey = "20FED99DBE644B818379C20653A8806F";
        $headers = [];
        array_push($headers, "Authorization:" . $apikey);
        //根据API的要求，定义相对应的Content-Type
        array_push($headers, "Content-Type" . ":" . "application/x-www-form-urlencoded; charset=UTF-8");
        $querys = "";
        $bodys = "txt=txt&th=th&filter=filter&corewordfilter=corewordfilter";
        $url = $host . $path;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, true);
        if(1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
