<?php


namespace App\Handlers;


class BaiduPayHandler
{
    //公钥
    private $rsaPubKeyStr;
    //私钥
    private $rsaPriKeyStr;

    public function __construct(array $options = [])
    {
        $this->rsaPubKeyStr = $options['rsaPubKeyStr'] ?? '';
        $this->rsaPriKeyStr = $options['reaPriKeyStr'] ?? '';
    }

    public function getSign(array $assocArr)
    {
        return $this->genSignWithRsa($assocArr, $this->rsaPriKeyStr);
    }

    public function checkSign(array $assocArr)
    {
        return $this->checkSignWithRsa($assocArr, $this->rsaPubKeyStr);
    }

    /**
     * @desc 私钥生成签名字符串 appKey+dealId+tpOrderId+totalAmount进行RSA加密后的签名
     * @param array $assocArr 关联数组 即参数data
     * @param $rsaPriKeyStr 私钥
     * @return bool|string 空字符串或签名
     * @throws Exception 报错
     */
    private function genSignWithRsa(array $assocArr, $rsaPriKeyStr)
    {
        $sign = '';
        if(empty($rsaPriKeyStr) || empty($assocArr)) {
            return $sign;
        }

        if(!function_exists('openssl_pkey_get_private') || !function_exists('openssl_sign')) {
            throw new Exception("openssl扩展不存在");
        }

        $priKey = openssl_pkey_get_private($rsaPriKeyStr);

        if(isset($assocArr['sign'])) {
            unset($assocArr['sign']);
        }

        ksort($assocArr); //按字母升序排序

        $parts = [];
        foreach($assocArr as $k => $v) {
            $parts[] = $k . '=' . $v;
        }
        $str = implode('&', $parts);

        openssl_sign($str, $sign, $priKey);
        openssl_free_key($priKey);

        return base64_encode($sign);
    }

    /**
     * @desc 公钥校验签名
     * @param array $assocArr 关联数组
     * @param $rsaPubKeyStr 公钥
     * @return bool 布尔
     * @throws Exception
     */
    private function checkSignWithRsa(array $assocArr, $rsaPubKeyStr)
    {
        if(!isset($assocArr['sign']) || empty($assocArr) || empty($rsaPubKeyStr)) {
            return false;
        }

        if(!function_exists('openssl_pkey_get_public') || !function_exists('openssl_verify')) {
            throw new Exception("openssl扩展不存在");
        }

        $sign = $assocArr['sign'];
        unset($assocArr['sign']);

        if(empty($assocArr)) {
            return false;
        }

        ksort($assocArr); //按字母升序排序
        $parts = [];
        foreach($assocArr as $k => $v) {
            $parts[] = $k . '=' . $v;
        }
        $str = implode('&', $parts);

        $sign = base64_decode($sign);

        $pubKey = chunk_split($rsaPubKeyStr, 64, "\n");
        $pubKey = "-----BEGIN PUBLIC KEY-----\n$pubKey-----END PUBLIC KEY-----\n";

        $pubKey = openssl_pkey_get_public($pubKey);

        $result = (bool)openssl_verify($str, $sign, $pubKey);
        openssl_free_key($pubKey);

        return $result;
    }
}
