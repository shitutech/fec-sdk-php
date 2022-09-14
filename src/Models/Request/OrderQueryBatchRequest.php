<?php

namespace Shitutech\Fec\Models\Request;

/**
 * Class OrderQueryBatchRequest 批次订单号查询订单
 * @package Shitutech\Fec\Models\Request
 */
final class OrderQueryBatchRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/order/query/batch';

    /**
     * @var string 批次流水号
     */
    protected $batchOrderId = '';

    /**
     * @param string $batchOrderId
     * @return OrderQueryBatchRequest
     */
    public function setBatchOrderId(string $batchOrderId): self
    {
        $this->batchOrderId = trim($batchOrderId);
        return $this;
    }
}