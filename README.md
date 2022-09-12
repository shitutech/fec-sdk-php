# 介绍

灵工 API PHP SDK

JAVA SDK 请参考： https://github.com/blinkingso/flexible-sdk-java

# 使用方法

## 配置仓库

在项目的 ``composer.json`` 内新增仓库配置

```json
{
  "minimum-stability": "dev",
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/shitutech/fec-sdk-php.git"
    }
  ]
}
```

执行安装：

```shell
composer.phar require shitutech/fec
```

## 调用

```php
use Shitutech\Fec\ClientConfig;
use Shitutech\Fec\ClientRequest;
use Shitutech\Fec\ClientResponse;
use Shitutech\Fec\Constants;
use Shitutech\Fec\Models\Request\AccInfoRequest;
use Shitutech\Fec\Models\Response\AccInfoResponse;

ClientConfig::getInstance()->setMerchantNo("A*****-******-*****")
    ->setProviderNo("")
    ->setProductNo("")
    ->setTaskCode("")
    ->setPrivateKey('');
    
try {
    $objAccInfo = new AccInfoRequest();
    $objAccInfo->setPayPass(Constants::PAY_PASS_ALIPAY);
    $objClientReq = new ClientRequest($objAccInfo);
    $respData = $objClientReq->send();

    $objClientResp = new ClientResponse(new AccInfoResponse(), $respData);

    /**
     * 这里声明的目的是为了 PHPStorm IDE 语法提示
     * @var AccInfoResponse $objResultResp
     */
    $objResultResp = $objClientResp->fetchResult();

    var_dump($objResultResp->getBalance());
} catch (Exception $e) {
    var_dump($e->getCode() . "::" . $e->getMessage());
}

```

