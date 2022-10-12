<?php

namespace Shitutech\Fec\Helpers;


use Exception;

class RemoteHelper
{
    /**
     * 返回随机字符串
     *
     * @param int $len
     * @param bool $onlyNum
     * @return string
     */
    public static function randomStr(int $len, bool $onlyNum = false): string
    {
        $numbers = '0123456789';
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $arr = [];

        if ($onlyNum === true) {
            $initString = $numbers;
        } else {
            $initString = $numbers . $alphabet;
        }

        $initLen = strlen($initString) - 1;

        for ($i = 0; $i < $len; $i++) {
            $initStart = $onlyNum === true && $i == 0 ? 1 : 0;
            $arr[] = $initString[rand($initStart, $initLen)];
        }

        return implode('', $arr);
    }

    /**
     * AES 密钥加密
     * @param string $aesKey
     * @param string $publicKey
     * @return string
     * @throws \Exception
     */
    public static function fetchEncryptKey(string $aesKey, string $publicKey): string
    {
        $publicKeyReal = "-----BEGIN PUBLIC KEY-----\n";
        $publicKeyReal .= wordwrap($publicKey, 64, "\n", true);
        $publicKeyReal .= "\n-----END PUBLIC KEY-----";

        $keyRes = openssl_pkey_get_public($publicKeyReal);
        if ($keyRes === false) {
            throw new \Exception("RSA 公钥无效！Err: " . openssl_error_string(), 1000);
        }

        $encrypted = '';
        $chunkItems = str_split($aesKey, 200);

        foreach ($chunkItems as $chunk) {
            $partialEncrypted = '';
            $encryptionOk = openssl_public_encrypt($chunk, $partialEncrypted, $keyRes);

            if ($encryptionOk === false) {
                throw new \Exception("RSA 公钥加密失败！Err: " . openssl_error_string(), 1000);
            }

            $encrypted .= $partialEncrypted;
        }

        return base64_encode($encrypted);
    }

    /**
     * 按照requestTime + nonce + merchantNo + requestData + encryptKey的顺序将此拼接起来
     * 然后RSA商户秘钥（SHA1WithRSA）签名
     * @param string $privateKey RSA商户秘钥
     * @param array $signData
     * @return string
     * @throws \Exception
     */
    public static function generateSign(string $privateKey, array $signData): string
    {
        $signStr = "{$signData['requestTime']}{$signData['nonce']}{$signData['merchantNo']}" .
            "{$signData['requestData']}{$signData['encryptKey']}";

        $privateKeyReal = "-----BEGIN RSA PRIVATE KEY-----\n"; // pkcs1
        //$privateKeyReal = "-----BEGIN PRIVATE KEY-----\n"; // pkcs8
        $privateKeyReal .= wordwrap($privateKey, 64, "\n", true);
        $privateKeyReal .= "\n-----END RSA PRIVATE KEY-----";
        //$privateKeyReal .= "\n-----END PRIVATE KEY-----";

        $keyRes = openssl_pkey_get_private($privateKeyReal, '');
        if ($keyRes === false) {
            throw new \Exception("RSA 私钥无效！Err: " . openssl_error_string(), 1000);
        }

        if (!openssl_sign($signStr, $signature, $keyRes)) {
            throw new \Exception("RSA 私钥签名失败！Err: " . openssl_error_string(), 1000);
        }

        return base64_encode($signature);
    }

    /**
     * 组装请求参数
     * @param string $privateKey
     * @param string $publicKey
     * @param string $merchantNo
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public static function getPostData(string $privateKey, string $publicKey, string $merchantNo, array $data): array
    {
        list($microseconds, $nowTime) = explode(' ', microtime());
        $microseconds = sprintf("%03d", $microseconds * 1000);

        $postData = [
            'requestTime' => date("YmdHis", $nowTime) . $microseconds,
            'nonce' => self::randomStr(32),
            'merchantNo' => $merchantNo,
        ];

        $aesKey = self::randomStr(24); // AES-128-ECB AES-192-ECB AES-256-ECB

        // 业务数据 AES 加密
        $postData['requestData'] = openssl_encrypt(json_encode($data), 'AES-192-ECB', $aesKey);
        if ($postData['requestData'] === false) {
            throw new \Exception("业务数据 AES 加密失败！Err: " . openssl_error_string(), 1000);
        }

        $postData['encryptKey'] = self::fetchEncryptKey($aesKey, $publicKey);
        $postData['sign'] = self::generateSign($privateKey, $postData);

        return $postData;
    }

    /**
     * 校验响应
     * @param string $respData
     * @throws \Exception
     */
    public static function checkResult(string $respData): void
    {
        if (empty($respData)) {
            throw new \Exception("响应数据为空", 1000);
        }

        $decodeData = json_decode($respData, true);
        if (!is_array($decodeData)) {
            throw new \Exception("响应数据 JSON 解码失败", 1000);
        }

        if (!isset($decodeData['code'])) {
            throw new \Exception("响应数据缺少状态码字段 code", 1000);
        }

        if ($decodeData['code'] != '200') {
            throw new \Exception("响应报告发生异常。Err: {$decodeData['code']}::{$decodeData['message']}", 1000);
        }

        if (!isset($decodeData['result'])) {
            throw new \Exception("响应数据缺少业务数据字段 result", 1000);
        }

        if (!is_array($decodeData['result']) || !$decodeData['result']) {
            throw new \Exception("业务数据无效", 1000);
        }

        $resultData = $decodeData['result'];

        if (!isset($resultData['statusCode'])) {
            throw new \Exception("业务数据缺少业务返回码字段 statusCode", 1000);
        }

        if ($resultData['statusCode'] != '1000') {
            throw new \Exception("银行响应报告发生异常。Err: {$resultData['statusCode']}:::{$resultData['msg']}", 2000);
        }

        return;
    }

    /**
     * 远程调用
     * @param string $privateKey
     * @param string $publicKey
     * @param string $merchantNo
     * @param array $data
     * @param string $url
     * @param int $timeOut
     * @return string
     * @throws \Exception
     */
    public static function remoteCurl(array $postData, string $url, $timeOut = 15): string
    {
        $dataJson = json_encode($postData);

        $ch = curl_init();

        $headers = [
            'User-Agent: ' . 'FecSdk/v1.0.0',
            'Content-Type: ' . 'application/json;charset=UTF-8',
            'Content-Length: ' . strlen($dataJson),
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeOut);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);

        $data = curl_exec($ch);
        /*$status = curl_getinfo($ch);
        echo json_encode($status);
        die;*/
        $errNo = curl_errno($ch);
        $errMsg = curl_error($ch);
        curl_close($ch);

        if ($errNo) {
            throw new \Exception("CURL 请求发生异常。Err: {$errNo}::{$errMsg}", 1000);
        }

        $data = trim($data);
        if (empty($data)) {
            throw new \Exception("CURL 远程请求响应未返回任何数据", 1000);
        }

        return $data;
    }

    /**
     * 调用入口
     * @param string $privateKey RSA商户秘钥
     * @param string $publicKey 系统公钥
     * @param string $merchantNo 商户号
     * @param array $data 业务参数数组
     * @param string $url 调用接口完整路由
     * @param int $timeOut 响应超时时间，默认15秒
     * @return string
     * @throws \Exception
     */
    public static function index(string $privateKey, string $publicKey, string $merchantNo, array $data, string $url, $timeOut = 15): string
    {
        try {
            //组装参数和签名等
            $postData = self::getPostData($privateKey, $publicKey, $merchantNo, $data);

            $responseData = self::remoteCurl($postData, $url, $timeOut);

            $logParams = ['inParams' => $postData, 'requestParams' => $data, 'outParams' => $responseData];
            $logMessage = "开始\n";
            $logMessage .= var_export($logParams, true) . "\n结束\n";
            error_log($logMessage, 3, '/data/log1/php_sdk' . '_' . date('Ymd') . '.log');

            //校验响应
            self::checkResult($responseData);

            return $responseData;
        } catch (Exception $e) {
            throw $e;
        }
    }
}