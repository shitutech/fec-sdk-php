<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class UserQueryResponse 用户信息查询
 * @package Shitutech\Fec\Models\Request
 */
final class UserQueryRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/query';

    /**
     * @var string 查询类型 1:查询基本信息 2:查询开户信息 3:查询会员ID
     */
    protected $type = '';

    /**
     * @var string 会员ID （查询类型 1/2必传）
     */
    protected $memberId = '';

    /**
     * @var string 支付通道 1:众邦 （查询类型 2 必传）
     */
    protected $payPass = '';

    /**
     * @var string 身份证号 （查询类型 3 必传）
     */
    protected $idCard = '';

    /**
     * @param string $type
     * @return UserQueryRequest
     * @throws \Exception
     */
    public function setType(string $type): self
    {
        $type = trim($type);
        if (!array_key_exists($type, Constants::TYPE_NAME)) {
            throw new \Exception("查询类型参数不合法", 1000);
        }

        $this->type = $type;
        return $this;
    }

    /**
     * @param string $memberId
     * @return UserQueryRequest
     */
    public function setMemberId(string $memberId): self
    {
        $memberId = trim($memberId);
        $this->memberId = $memberId;
        return $this;
    }

    /**
     * @param string $payPass
     * @return UserQueryRequest
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
     * @param string $idCard
     * @return UserQueryRequest
     * @throws \Exception
     */
    public function setIdCard(string $idCard): self
    {
        $idCard = trim($idCard);
        UtilHelper::verifyIdCard($idCard);

        $this->idCard = $idCard;
        return $this;
    }
}