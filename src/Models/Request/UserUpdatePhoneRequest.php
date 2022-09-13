<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class UserUpdatePhoneRequest 用户信息变更 - 注册手机号
 * @package Shitutech\Fec\Models\Request
 */
class UserUpdatePhoneRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/update';

    /**
     * @var string 会员ID
     */
    protected $memberId = '';

    /**
     * @var string 变更类型 1:变更注册手机号 2:变更影像件 3:拓展业务类型 4：变更结算卡信息
     */
    protected $changeType = Constants::CHANGE_TYPE_PHONE;

    /**
     * @var string 商户编号
     */
    protected $merchantNo = '';

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
     * @param string $memberId
     * @return UserUpdatePhoneRequest
     */
    public function setMemberId(string $memberId): self
    {
        $this->memberId = trim($memberId);
        return $this;
    }

    /**
     * @param string $merchantNo
     * @return UserUpdatePhoneRequest
     */
    public function setMerchantNo(string $merchantNo): self
    {
        $this->merchantNo = trim($merchantNo);
        return $this;
    }

    /**
     * @param string $phone
     * @return UserUpdatePhoneRequest
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
     * @return UserUpdatePhoneRequest
     */
    public function setImgIdCardFront(string $imgIdCardFront): self
    {
        $this->imgIdCardFront = trim($imgIdCardFront);
        return $this;
    }

    /**
     * @param string $imgIdCardBack
     * @return UserUpdatePhoneRequest
     */
    public function setImgIdCardBack(string $imgIdCardBack): self
    {
        $this->imgIdCardBack = trim($imgIdCardBack);
        return $this;
    }

}