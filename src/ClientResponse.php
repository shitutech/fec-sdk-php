<?php

namespace Shitutech\Fec;

use Shitutech\Fec\Models\Response\BaseResponse;

final class ClientResponse
{
    /**
     * @var BaseResponse|null
     */
    protected $response = null;

    /**
     * @var string
     */
    protected $respData = '';

    /**
     * @param BaseResponse $response
     * @param string $respJsonData
     */
    public function __construct(BaseResponse $response, string $respJsonData)
    {
        $this->response = $response;
        $this->respData = $respJsonData;
    }

    /**
     * @return BaseResponse
     * @throws \Exception
     */
    public function fetchResult(): BaseResponse
    {
        $respData = trim($this->respData);
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

        $this->response->setProperty($resultData);

        return $this->response;
    }
}
