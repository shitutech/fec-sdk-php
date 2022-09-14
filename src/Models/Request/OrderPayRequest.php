<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\ClientConfig;
use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class OrderPayRequest 订单支付
 * @package Shitutech\Fec\Models\Request
 */
final class OrderPayRequest extends BaseRequest
{
    protected $apiPath = 'api/fec/order/pay';

    /**
     * @var string 服务商号
     */
    protected $providerNo = '';

    /**
     * @var string 任务编号
     */
    protected $taskCode = '';

    /**
     * @var string 产品编号
     */
    protected $productCode = '';

    /**
     * @var string 手续费承担方 1:企业承担 2:客户承担
     */
    protected $costUndertaker = '';

    /**
     * @var string 支付通道（1:众邦 2:支付宝）
     */
    protected $payPass = '';

    /**
     * @var string 批次号 格式：20200101-00001 当天日期+五位序列号
     */
    protected $batchNumber = '';

    /**
     * @var array 支付信息 以下字段是list信息 数据格式[{“memberId”:”134814782XXX”,”name”:”李XX”,”idCard”:”2305231XXX”,”fee”:”10.00”}]
     */
    protected $payList = [];

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
     * @var string 支付宝号 支付通道2 必传
     */
    protected $aliPayNo = '';

    /**
     * @var string 金额 单位元，精确到两位小数点 示例： 10.05元
     */
    protected $fee = '';

    /**
     * OrderPayRequest constructor.
     */
    public function __construct()
    {
        $this->providerNo = ClientConfig::getInstance()->getProviderNo();
        $this->taskCode = ClientConfig::getInstance()->getTaskCode();
        $this->productCode = ClientConfig::getInstance()->getProductNo();
    }

    /**
     * @param string $costUndertaker
     * @return OrderPayRequest
     * @throws \Exception
     */
    public function setCostUndertaker(string $costUndertaker): self
    {
        $costUndertaker = trim($costUndertaker);
        if (!array_key_exists($costUndertaker, Constants::COST_UNDER_TAKER_NAME)) {
            throw new \Exception("手续费承担方参数不合法", 1000);
        }

        $this->costUndertaker = $costUndertaker;
        return $this;
    }

    /**
     * @param string $payPass
     * @return OrderPayRequest
     * @throws \Exception
     */
    public function setPayPass(string $payPass): self
    {
        $payPass = trim($payPass);

        if (!array_key_exists($payPass, Constants::PAY_PASS_NAME)) {
            throw new \Exception("支付通道参数不合法", 1000);
        }

        $this->payPass = $payPass;
        return $this;
    }

    /**
     * @param string $batchNumber
     * @return OrderPayRequest
     */
    public function setBatchNumber(string $batchNumber): self
    {
        $this->batchNumber = trim($batchNumber);
        return $this;
    }

    /**
     * @param array $payList
     * @return OrderPayRequest
     */
    public function setPayList(array $payList): self
    {
        $this->payList = $payList;
        return $this;
    }

    /**
     * @param string $memberId
     * @return OrderPayRequest
     */
    public function setMemberId(string $memberId): self
    {
        $this->memberId = trim($memberId);
        return $this;
    }

    /**
     * @param string $name
     * @return OrderPayRequest
     */
    public function setName(string $name): self
    {
        $this->name = trim($name);
        return $this;
    }

    /**
     * @param string $idCard
     * @return OrderPayRequest
     * @throws \Exception
     */
    public function setIdCard(string $idCard): self
    {
        $idCard = trim($idCard);
        UtilHelper::verifyIdCard($idCard);

        $this->idCard = $idCard;
        return $this;
    }

    /**
     * @param string $aliPayNo
     * @return OrderPayRequest
     */
    public function setAliPayNo(string $aliPayNo): self
    {
        $this->aliPayNo = trim($aliPayNo);
        return $this;
    }

    /**
     * @param string $fee
     * @return OrderPayRequest
     */
    public function setFee(string $fee): self
    {
        $this->fee = trim($fee);
        return $this;
    }


}