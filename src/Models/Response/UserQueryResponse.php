<?php

namespace Shitutech\Fec\Models\Response;

/**
 * Class UserQueryResponse 用户信息查询接口
 * @package Shitutech\Fec\Models\Response
 */
class UserQueryResponse extends BaseResponse
{
    /**
     * @var string 姓名 （查询类型 1 返回）
     */
    protected $name = '';

    /**
     * @var string 身份证号 （查询类型 1 返回）
     */
    protected $idCard = '';

    /**
     * @var array 业务类型 1委托代征2.个体户注册(分包)3.自然人代开4.临时税务登记 （查询类型 1 返回）
     */
    protected $busTypeList = [];

    /**
     * @var string 开户行编号 （查询类型 1 返回）
     */
    protected $bankNo = '';

    /**
     * @var string 开户行 （查询类型1 返回）
     */
    protected $bankName = '';

    /**
     * @var string 卡号 （查询类型 1 返回）
     */
    protected $cardNo = '';

    /**
     * @var string 银行预留手机号 （查询类型 1 返回）
     */
    protected $bankPhone = '';

    /**
     * @var string 账户状态 0:未开通 1:开通中 2:开通成功 3:开通失败 （查询类型 2 返回）
     */
    protected $acctStatus = '0';

    /**
     * @var string 会员ID （查询类型 3 返回）
     */
    protected $memberId = '0';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name ?: '';
    }

    /**
     * @return string
     */
    public function getIdCard(): string
    {
        return $this->idCard ?: '';
    }

    /**
     * @return array
     */
    public function getBusTypeList(): array
    {
        return $this->busTypeList ?: [];
    }

    /**
     * @return string
     */
    public function getBankNo(): string
    {
        return $this->bankNo ?: '';
    }

    /**
     * @return string
     */
    public function getBankName(): string
    {
        return $this->bankName ?: '';
    }

    /**
     * @return string
     */
    public function getCardNo(): string
    {
        return $this->cardNo ?: '';
    }

    /**
     * @return string
     */
    public function getBankPhone(): string
    {
        return $this->bankPhone ?: '';
    }

    /**
     * @return string
     */
    public function getAcctStatus(): string
    {
        return $this->acctStatus ?: '0';
    }

    /**
     * @return string
     */
    public function getMemberId(): string
    {
        return $this->memberId;
    }
}