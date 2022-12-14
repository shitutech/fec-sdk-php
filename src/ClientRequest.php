<?php

namespace Shitutech\Fec;

use Shitutech\Fec\Helpers\UtilHelper;
use Shitutech\Fec\Models\Request\BaseRequest;

final class ClientRequest
{
    /**
     * @var BaseRequest|null
     */
    protected $request = null;

    /**
     * @var string
     */
    protected $userAgent = 'FecSdk/v' . Constants::VERSION;

    /**
     * @var string
     */
    protected $contentType = 'application/json;charset=UTF-8';

    /**
     * @var float
     */
    protected $timeout = 15.0;

    public function __construct(BaseRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @param string $userAgent
     * @return ClientRequest
     */
    public function setUserAgent(string $userAgent): ClientRequest
    {
        $userAgent = trim($userAgent);
        if ($userAgent) {
            $this->userAgent .= " {$userAgent}";
        }

        return $this;
    }

    /**
     * @param float $timeout
     * @return ClientRequest
     */
    public function setTimeout(float $timeout): ClientRequest
    {
        $this->timeout = $timeout > 0 ? $timeout : 15.0;
        return $this;
    }

    /**
     * @return string
     *
     * @throws \Exception
     * @see https://showdoc.51wanquan.com/web/#/31/1881
     */
    public function send(): string
    {
        $domain = 'https://fec.51wanquan.com';

        $postData = $this->getBizParams();
        $dataJson = json_encode($postData);

        $ch = curl_init();

        $headers = [
            'User-Agent: ' . $this->userAgent,
            'Content-Type: ' . $this->contentType,
            'Content-Length: ' . strlen($dataJson),
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $domain . $this->request->getApiPath());
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);

        $data = curl_exec($ch);
        // $status = curl_getinfo($ch);
        $errNo = curl_errno($ch);
        $errMsg = curl_error($ch);
        curl_close($ch);

        if ($errNo) {
            throw new \Exception("CURL ?????????????????????Err: {$errNo}::{$errMsg}", 1000);
        }

        $data = trim($data);
        if (empty($data)) {
            throw new \Exception("CURL ???????????????????????????????????????", 1000);
        }

        return $data;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getBizParams(): array
    {
        list($microseconds, $nowTime) = explode(' ', microtime());
        $microseconds = sprintf("%03d", $microseconds * 1000);

        $postData = [
            'requestTime' => date("YmdHis", $nowTime) . $microseconds,
            'nonce' => UtilHelper::randomStr(32),
            'merchantNo' => ClientConfig::getInstance()->getMerchantNo(),
        ];

        $aesKey = UtilHelper::randomStr(24); // AES-128-ECB AES-192-ECB AES-256-ECB

        // ???????????? AES ??????
        $bizData = $this->request->fetchBizData();
        $postData['requestData'] = openssl_encrypt($bizData, 'AES-192-ECB', $aesKey);
        if ($postData['requestData'] === false) {
            throw new \Exception("???????????? AES ???????????????Err: " . openssl_error_string(), 1000);
        }

        $postData['encryptKey'] = $this->fetchEncryptKey($aesKey);
        $postData['sign'] = $this->generateSign($postData);

        return $postData;
    }

    /**
     * AES ????????????
     *
     * @param string $aesKey
     * @return string
     * @throws \Exception
     */
    protected function fetchEncryptKey(string $aesKey): string
    {
        $publicKeyReal = "-----BEGIN PUBLIC KEY-----\n";
        $publicKeyReal .= wordwrap(ClientConfig::getInstance()->getSystemPublicKey(), 64, "\n", true);
        $publicKeyReal .= "\n-----END PUBLIC KEY-----";

        $keyRes = openssl_pkey_get_public($publicKeyReal);
        if ($keyRes === false) {
            throw new \Exception("RSA ???????????????Err: " . openssl_error_string(), 1000);
        }

        $encrypted = '';
        $chunkItems = str_split($aesKey, 200);

        foreach ($chunkItems as $chunk) {
            $partialEncrypted = '';
            $encryptionOk = openssl_public_encrypt($chunk, $partialEncrypted, $keyRes);

            if ($encryptionOk === false) {
                throw new \Exception("RSA ?????????????????????Err: " . openssl_error_string(), 1000);
            }

            $encrypted .= $partialEncrypted;
        }

        return base64_encode($encrypted);
    }

    /**
     * ??????requestTime + nonce + merchantNo + requestData + encryptKey???????????????????????????
     * ??????RSA???????????????SHA1WithRSA?????????
     *
     * @param $signData
     * @return string
     * @throws \Exception
     */
    protected function generateSign(&$signData): string
    {
        $signStr = "{$signData['requestTime']}{$signData['nonce']}{$signData['merchantNo']}" .
            "{$signData['requestData']}{$signData['encryptKey']}";

        $privateKeyReal = "-----BEGIN RSA PRIVATE KEY-----\n"; // pkcs1
        //$privateKeyReal = "-----BEGIN PRIVATE KEY-----\n"; // pkcs8
        $privateKeyReal .= wordwrap(ClientConfig::getInstance()->getPrivateKey(), 64, "\n", true);
        $privateKeyReal .= "\n-----END RSA PRIVATE KEY-----";
        //$privateKeyReal .= "\n-----END PRIVATE KEY-----";

        $keyRes = openssl_pkey_get_private($privateKeyReal, '');
        if ($keyRes === false) {
            throw new \Exception("RSA ???????????????Err: " . openssl_error_string(), 1000);
        }

        if (!openssl_sign($signStr, $signature, $keyRes)) {
            throw new \Exception("RSA ?????????????????????Err: " . openssl_error_string(), 1000);
        }

        return base64_encode($signature);
    }

    /**
     * @param string $contentType
     * @return ClientRequest
     */
    public function setContentType(string $contentType): ClientRequest
    {
        $contentType = trim($contentType);
        if ($contentType) {
            $this->contentType = $contentType;
        }

        return $this;
    }
}
