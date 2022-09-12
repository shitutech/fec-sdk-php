<?php

namespace Shitutech\Fec\Models\Response;

final class AccInfoResponse extends BaseResponse
{
    /**
     * @var string 账户余额 单位元，精确到两位小数点 示例： 10.05元
     */
    protected $balance = '0.00';

    /**
     * @var string 可用余额 单位元，精确到两位小数点 示例： 10.05元
     */
    protected $availableFee = '0.00';

    /**
     * @var string 冻结金额 单位元，精确到两位小数点 示例： 10.05元
     */
    protected $frozenBalance = '0.00';

    /**
     * @return string
     */
    public function getBalance(): string
    {
        return $this->balance ?: '0.00';
    }

    /**
     * @return string
     */
    public function getAvailableFee(): string
    {
        return $this->availableFee ?: '0.00';
    }

    /**
     * @return string
     */
    public function getFrozenBalance(): string
    {
        return $this->frozenBalance ?: '0.00';
    }
}
