<?php

namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\Constants;

final class AccInfoRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/info';

    /**
     * @var string 支付通道（1:众邦, 2: 支付宝）
     */
    protected $payPass = "";

    /**
     * @return string
     */
    public function getPayPass(): string
    {
        return $this->payPass;
    }

    /**
     * @param string $payPass
     * @return AccInfoRequest
     * @throws \Exception
     */
    public function setPayPass(string $payPass): AccInfoRequest
    {
        $payPass = trim($payPass);

        if ($payPass != Constants::PAY_PASS_ZB && $payPass != Constants::PAY_PASS_ALIPAY) {
            throw new \Exception("支付通道参数不合法", 1000);
        }

        $this->payPass = $payPass;
        return $this;
    }
}
