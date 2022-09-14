<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\ClientConfig;
use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class UserUpdateCardRequest 用户信息变更 - 结算卡信息
 * @package Shitutech\Fec\Models\Request
 */
final class UserUpdateCardRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/update';

    /**
     * @var string 会员ID
     */
    protected $memberId = '';

    /**
     * @var string 变更类型 1:变更注册手机号 2:变更影像件 3:拓展业务类型 4：变更结算卡信息
     */
    protected $changeType = Constants::CHANGE_TYPE_CARD;

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
     * @var string 支付通道（1:众邦, 2: 支付宝） 变更类型为4必传
     */
    protected $payPass = '';

    /**
     * @var string 开户行编号 变更类型为4必传
     */
    protected $bankNo = '';

    /**
     * @var string 结算卡号 变更类型为4必传
     */
    protected $cardNo = '';

    /**
     * @var string 银行预留手机号 变更类型为4必传
     */
    protected $bankPhone = '';

    /**
     * @var string 银行卡照片 变更类型为4必传(暂时不传, 后期上线后会有变动)
     */
    protected $imgBank = '';

    /**
     * UserUpdateCardRequest constructor.
     */
    public function __construct()
    {
        $this->merchantNo = ClientConfig::getInstance()->getMerchantNo();
    }

    /**
     * @param string $memberId
     * @return UserUpdateCardRequest
     */
    public function setMemberId(string $memberId): self
    {
        $this->memberId = trim($memberId);
        return $this;
    }

    /**
     * @param string $phone
     * @return UserUpdateCardRequest
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
     * @return UserUpdateCardRequest
     */
    public function setImgIdCardFront(string $imgIdCardFront): self
    {
        $this->imgIdCardFront = trim($imgIdCardFront);
        return $this;
    }

    /**
     * @param string $imgIdCardBack
     * @return UserUpdateCardRequest
     */
    public function setImgIdCardBack(string $imgIdCardBack): self
    {
        $this->imgIdCardBack = trim($imgIdCardBack);
        return $this;
    }

    /**
     * @param string $payPass
     * @return UserUpdateCardRequest
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
     * @param string $bankNo
     * @return UserUpdateCardRequest
     */
    public function setBankNo(string $bankNo): self
    {
        $this->bankNo = trim($bankNo);
        return $this;
    }

    /**
     * @param string $cardNo
     * @return UserUpdateCardRequest
     */
    public function setCardNo(string $cardNo): self
    {
        $this->cardNo = trim($cardNo);
        return $this;
    }

    /**
     * @param string $bankPhone
     * @return UserUpdateCardRequest
     * @throws \Exception
     */
    public function setBankPhone(string $bankPhone): self
    {
        $bankPhone = trim($bankPhone);

        UtilHelper::verifyMobile($bankPhone);

        $this->bankPhone = $bankPhone;
        return $this;
    }

    /**
     * @param string $imgBank
     * @return UserUpdateCardRequest
     */
    public function setImgBank(string $imgBank): self
    {
        $this->imgBank = trim($imgBank);
        return $this;
    }
}