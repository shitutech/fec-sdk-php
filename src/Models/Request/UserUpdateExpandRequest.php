<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\ClientConfig;
use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class UserUpdateExpandRequest 用户信息变更 - 拓展业务类型
 * @package Shitutech\Fec\Models\Request
 */
final class UserUpdateExpandRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/update';

    /**
     * @var string 会员ID
     */
    protected $memberId = '';

    /**
     * @var string 变更类型 1:变更注册手机号 2:变更影像件 3:拓展业务类型 4：变更结算卡信息
     */
    protected $changeType = Constants::CHANGE_TYPE_EXPAND;

    /**
     * @var string 商户编号
     */
    protected $merchantNo = '';

    /**
     * @var string 服务商号 变更类型为3必传
     */
    protected $providerNo = '';

    /**
     * @var string 注册手机号
     */
    protected $phone = '';

    /**
     * @var string 身份证正面 base64格式
     */
    protected $imgIdCardFront = '';

    /**
     * @var string 身份证反面 base64格式
     */
    protected $imgIdCardBack = '';

    /**
     * @var string 业务类型 委托代征2.个体户注册(分包)3.自然人代开4.临时税务登记 变更类型为3必传
     */
    protected $busType = '';

    /**
     * UserUpdateExpandRequest constructor.
     */
    public function __construct()
    {
        $this->merchantNo = ClientConfig::getInstance()->getMerchantNo();
    }

    /**
     * @param string $memberId
     * @return UserUpdateExpandRequest
     */
    public function setMemberId(string $memberId): self
    {
        $this->memberId = trim($memberId);
        return $this;
    }

    /**
     * @param string $providerNo
     * @return UserUpdateExpandRequest
     */
    public function setProviderNo(string $providerNo): self
    {
        $this->providerNo = trim($providerNo);
        return $this;
    }

    /**
     * @param string $phone
     * @return UserUpdateExpandRequest
     * @throws \Exception
     */
    public function setPhone(string $phone): self
    {
        $phone = trim($phone);
        UtilHelper::verifyMobile($phone);

        $this->phone = $phone;
        return $this;
    }

    /**
     * @param string $imgIdCardFront
     * @return UserUpdateExpandRequest
     */
    public function setImgIdCardFront(string $imgIdCardFront): self
    {
        $this->imgIdCardFront = trim($imgIdCardFront);
        return $this;
    }

    /**
     * @param string $imgIdCardBack
     * @return UserUpdateExpandRequest
     */
    public function setImgIdCardBack(string $imgIdCardBack): self
    {
        $this->imgIdCardBack = trim($imgIdCardBack);
        return $this;
    }

    /**
     * @param string $busType
     * @return UserUpdateExpandRequest
     * @throws \Exception
     */
    public function setBusType(string $busType): self
    {
        $busType = trim($busType);
        if (!array_key_exists($busType, Constants::BUS_TYPE_NAME)) {
            throw new \Exception("业务类型参数不合法", 1000);
        }

        $this->busType = $busType;
        return $this;
    }
}