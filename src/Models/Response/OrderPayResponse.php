<?php

namespace Shitutech\Fec\Models\Response;

/**
 * Class OrderPayResponse 订单支付
 * @package Shitutech\Fec\Models\Response
 */
final class OrderPayResponse extends BaseResponse
{
    /**
     * @var string 系统批次流水号
     */
    protected $batchOrderId = '';

    /**
     * @var array 支付信息 以下字段是list信息 （code=1001返回以下信息）
     */
    protected $payList = [];

    /**
     * @var array 支付信息 以下字段是list信息 （code=1001返回以下信息）
     */
    protected $failList = [];

    /**
     * @return string
     */
    public function getBatchOrderId(): string
    {
        return $this->batchOrderId ?: '';
    }

    /**
     * @return array
     */
    public function getPayList(): array
    {
        return $this->payList ?: [];
    }

    /**
     * @return array
     */
    public function getFailList(): array
    {
        return $this->failList ?: [];
    }


}