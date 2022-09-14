<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\ClientConfig;
use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class UserOpenVideoRequest 用户账户开户(活体认证)
 * @package Shitutech\Fec\Models\Request
 */
final class UserOpenVideoRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/open/video';

    /**
     * @var string 会员ID
     */
    protected $memberId = '';

    /**
     * @var string 支付通道（1:众邦）
     */
    protected $payPass = '';

    /**
     * @var string 开户行编号 （众邦必传）
     */
    protected $bankNo = '';

    /**
     * @var string 卡号 （众邦必传）
     */
    protected $cardNo = '';

    /**
     * @var string 商户编号
     */
    protected $merchantNo = '';

    /**
     * @var string 银行预留手机号（众邦必传）
     */
    protected $bankPhone = '';

    /**
     * @var string 银行卡照片 格式要求：Base64值；Base64编码后的大小不超2M（众邦必传）
     */
    protected $imgBank = '';

    /**
     * @var string 面部高清照，格式要求：Base64值；Base64编码后的大小不超2M
     */
    protected $imgFace = '';

    /**
     * @var string (暂未上线)用于活体检测的视频，视频的Base64值；Base64编码后的大小不超5M，支持mp4、avi、flv格式。请使用标准的Base64编码方式(带=补位)，编码规范参考RFC4648
     */
    protected $videoBase64 = '';

    /**
     * @var string 证件有效期开始日期 （众邦必传） 格式：yyyyMMdd 20000101
     */
    protected $validDateStart = '';

    /**
     * @var string 证件有效期截止日期 （众邦必传） 格式：yyyyMMdd 20180101 长期上送”长期”中文字符
     */
    protected $validDateEnd = '';

    /**
     * @var string 住址 （众邦必传
     */
    protected $address = '';

    /**
     * @var string IP 地址 （众邦必传）
     */
    protected $ipAdr = '';

    public function __construct()
    {
        $this->merchantNo = ClientConfig::getInstance()->getMerchantNo();
    }

    /**
     * @param string $memberId
     * @return UserOpenVideoRequest
     */
    public function setMemberId(string $memberId): self
    {
        $this->memberId = trim($memberId);
        return $this;
    }

    /**
     * @param string $payPass
     * @return UserOpenVideoRequest
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
     * @return UserOpenVideoRequest
     */
    public function setBankNo(string $bankNo): self
    {
        $this->bankNo = trim($bankNo);
        return $this;
    }

    /**
     * @param string $cardNo
     * @return UserOpenVideoRequest
     */
    public function setCardNo(string $cardNo): self
    {
        $this->cardNo = trim($cardNo);
        return $this;
    }

    /**
     * @param string $bankPhone
     * @return UserOpenVideoRequest
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
     * @return UserOpenVideoRequest
     */
    public function setImgBank(string $imgBank): self
    {
        $this->imgBank = trim($imgBank);
        return $this;
    }

    /**
     * @param string $imgFace
     * @return UserOpenVideoRequest
     */
    public function setImgFace(string $imgFace): self
    {
        $this->imgFace = trim($imgFace);
        return $this;
    }

    /**
     * @param string $videoBase64
     * @return UserOpenVideoRequest
     */
    public function setVideoBase64(string $videoBase64): self
    {
        $this->videoBase64 = trim($videoBase64);
        return $this;
    }

    /**
     * @param string $validDateStart
     * @return UserOpenVideoRequest
     */
    public function setValidDateStart(string $validDateStart): self
    {
        $this->validDateStart = trim($validDateStart);
        return $this;
    }

    /**
     * @param string $validDateEnd
     * @return UserOpenVideoRequest
     */
    public function setValidDateEnd(string $validDateEnd): self
    {
        $this->validDateEnd = trim($validDateEnd);
        return $this;
    }

    /**
     * @param string $address
     * @return UserOpenVideoRequest
     */
    public function setAddress(string $address): self
    {
        $this->address = trim($address);
        return $this;
    }

    /**
     * @param string $ipAdr
     * @return UserOpenVideoRequest
     */
    public function setIpAdr(string $ipAdr): self
    {
        $this->ipAdr = trim($ipAdr);
        return $this;
    }
}