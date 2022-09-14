<?php

namespace Shitutech\Fec\Models\Response;

/**
 * Class OrderQueryDetailResponse 子订单详情查询
 * @package Shitutech\Fec\Models\Response
 */
final class OrderQueryDetailResponse extends BaseResponse
{
    /**
     * @var string 交易流水号
     */
    protected $orderNo = '';

    /**
     * @var string 批次流水号
     */
    protected $batchOrderId = '';

    /**
     * @var string 会员ID
     */
    protected $memberId = '';

    /**
     * @var string 会员名称
     */
    protected $name = '';

    /**
     * @var string 身份证号
     */
    protected $idCard = '';

    /**
     * @var string 金额
     */
    protected $fee = '0.00';

    /**
     * @var string 支付状态[0:待支付 1:支付中 2:支付成功 3:支付失败4:已撤回]
     */
    protected $payStatus = '0';

    /**
     * @var string 支付时间 格式：yyyyMMddHHmmss
     */
    protected $payTime = '';

    /**
     * @var string 备注
     */
    protected $remark = '';

    /**
     * @return string
     */
    public function getOrderNo(): string
    {
        return $this->orderNo ?: '';
    }

    /**
     * @return string
     */
    public function getBatchOrderId(): string
    {
        return $this->batchOrderId ?: '';
    }

    /**
     * @return string
     */
    public function getMemberId(): string
    {
        return $this->memberId ?: '';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?: '';
    }

    /**
     * @return string
     */
    public function getIdCard(): string
    {
        return $this->idCard ?: '';
    }

    /**
     * @return string
     */
    public function getFee(): string
    {
        return $this->fee ?: '0.00';
    }

    /**
     * @return string
     */
    public function getPayStatus(): string
    {
        return $this->payStatus ?: '0';
    }

    /**
     * @return string
     */
    public function getPayTime(): string
    {
        return $this->payTime ?: '';
    }

    /**
     * @return string
     */
    public function getRemark(): string
    {
        return $this->remark ?: '';
    }


}