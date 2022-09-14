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

    // busType 业务类型 1:委托代征;2:个体户注册(分包);3:自然人代开;4:临时税务登记
    const BUS_TYPE_ENTRUST = '1';
    const BUS_TYPE_INDIVIDUAL = '2';
    const BUS_TYPE_PERSON = '3';
    const BUS_TYPE_TEMPORARY = '4';

    const BUS_TYPE_NAME = [
        self::BUS_TYPE_ENTRUST => '委托代征',
        self::BUS_TYPE_INDIVIDUAL => '个体户注册(分包)',
        self::BUS_TYPE_PERSON => '自然人代开',
        self::BUS_TYPE_TEMPORARY => '临时税务登记',
    ];

    // type 查询类型 1:查询基本信息 2:查询开户信息 3:查询会员ID
    const TYPE_BASE_INFO = '1';
    const TYPE_ACCOUNT_INFO = '2';
    const TYPE_MEMBER_ID = '3';

    const TYPE_NAME = [
        self::TYPE_BASE_INFO => '查询基本信息',
        self::TYPE_ACCOUNT_INFO => '查询开户信息',
        self::TYPE_MEMBER_ID => '查询会员ID',
    ];

    //changeType 变更类型 1:变更注册手机号 2:变更影像件 3:拓展业务类型 4：变更结算卡信息
    const CHANGE_TYPE_PHONE = '1';
    const CHANGE_TYPE_IMAGE = '2';
    const CHANGE_TYPE_EXPAND = '3';
    const CHANGE_TYPE_CARD = '4';

    const CHANGE_TYPE_NAME = [
        self::CHANGE_TYPE_PHONE => '变更注册手机号',
        self::CHANGE_TYPE_IMAGE => '变更影像件',
        self::CHANGE_TYPE_EXPAND => '拓展业务类型',
        self::CHANGE_TYPE_CARD => '变更结算卡信息',
    ];

    //costUndertaker 手续费承担方 1:企业承担 2:客户承担
    const COST_UNDER_TAKER_ENTERPRISE = '1';
    const COST_UNDER_TAKER_CUSTOMER = '2';

    const COST_UNDER_TAKER_NAME = [
        self::COST_UNDER_TAKER_ENTERPRISE => '企业承担',
        self::COST_UNDER_TAKER_CUSTOMER => '客户承担',
    ];
}
