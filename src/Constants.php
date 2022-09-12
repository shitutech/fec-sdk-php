<?php

namespace Shitutech\Fec;

final class Constants
{
    const VERSION = '1.0.0';
    
    // payPass 支付通道
    const PAY_PASS_ZB = '1';
    const PAY_PASS_ALIPAY = '2';

    const PAY_PASS_NAME = [
        self::PAY_PASS_ZB => '众邦',
        self::PAY_PASS_ALIPAY => '支付宝',
    ];

}
