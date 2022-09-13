<?php


namespace Shitutech\Fec\Models\Request;

use Shitutech\Fec\ClientConfig;
use Shitutech\Fec\Constants;
use Shitutech\Fec\Helpers\UtilHelper;

/**
 * Class UserRegisterRequest 用户注册
 * @package Shitutech\Fec\Models\Request
 */
final class UserRegisterRequest extends BaseRequest
{
    protected $apiPath = '/api/fec/acct/register';

    /**
     * @var string 服务商号
     */
    protected $providerNo = '';

    /**
     * @var string 姓名
     */
    protected $name = '';

    /**
     * @var string 身份证号
     */
    protected $idCard = '';

    /**
     * @var string 手机号
     */
    protected $phone = '';

    /**
     * @var string 身份证正面 base64格式 Base64编码后的大小不超2M
     */
    protected $imgIdCardFront = '';

    /**
     * @var string 身份证反面 base64格式 Base64编码后的大小不超2M
     */
    protected $imgIdCardBack = '';

    /**
     * @var string 业务类型 1委托代征2.个体户注册(分包)3.自然人代开4.临时税务登记
     */
    protected $busType = '';

    /**
     * UserRegisterRequest constructor.
     */
    public function __construct()
    {
        $this->providerNo = ClientConfig::getInstance()->getProviderNo();
    }

    /**
     * @param string $name
     * @return UserRegisterRequest
     */
    public function setName(string $name): self
    {
        $this->name = trim($name);
        return $this;
    }

    /**
     * @param string $idCard
     * @return UserRegisterRequest
     * @throws \Exception
     */
    public function setIdCard(string $idCard): self
    {
        $idCard = trim($idCard);

        UtilHelper::verifyIdCard($idCard);

        $this->idCard = $idCard;
        return $this;
    }

    /**
     * @param string $phone
     * @return UserRegisterRequest
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
     * @return UserRegisterRequest
     */
    public function setImgIdCardFront(string $imgIdCardFront): self
    {
        $this->imgIdCardFront = trim($imgIdCardFront);
        return $this;
    }

    /**
     * @param string $imgIdCardBack
     * @return UserRegisterRequest
     */
    public function setImgIdCardBack(string $imgIdCardBack): self
    {
        $this->imgIdCardBack = trim($imgIdCardBack);
        return $this;
    }

    /**
     * @param string $busType
     * @return UserRegisterRequest
     * @throws \Exception
     */
    public function setBusType(string $busType): self
    {
        $busType = trim($busType);
        if (!array_key_exists($busType, Constants::BUS_TYPE_NAME)) {
            throw new \Exception("业务类型参数不合法", 1000);
        }

        $this->busType = $busType;
        return $this;
    }
}
