<?php

namespace Shitutech\Fec\Models\Request;

/**
 * Class OrderQueryDetailRequest 子订单详情查询
 * @package Shitutech\Fec\Models\Request
 */
final class OrderQueryDetailRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/order/query/detail';

    /**
     * @var string 交易流水号(50)
     */
    protected $orderNo = '';

    /**
     * @param string $orderNo
     * @return OrderQueryDetailRequest
     */
    public function setOrderNo(string $orderNo): self
    {
        $this->orderNo = trim($orderNo);
        return $this;
    }
}