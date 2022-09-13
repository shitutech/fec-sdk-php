<?php

namespace Shitutech\Fec\Models\Response;

/**
 * Class UserRegisterResponse 用户注册
 * @package Shitutech\Fec\Models\Response
 */
final class UserRegisterResponse extends BaseResponse
{
    /**
     * @var string 会员ID 示例： 10
     */
    protected $memberId = '0';

    /**
     * @return string
     */
    public function getMemberId(): string
    {
        return $this->memberId ?: '0';
    }
}