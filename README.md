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

## 调用方式一（强烈推荐，旧版本，v2版本皆可用。v2版本目前只能用这个）

```php
use Shitutech\Fec\Helpers\remoteHelper;

//RSA商户秘钥
$privateKey = 'xxx';
//系统公钥
$publicKey = 'xxx';

//以商户信息查询接口为例 demo
$domain = 'https://fec.51wanquan.com';//域名
$url = $domain . '/api/fec/v2/acct/info';//接口完整路由
$merchantNo = 'xxx';//商户号，必须要的参数
//对应接口业务参数
$data = [
    'accountType' => '2',
    'payPass' => '4',
    'providerNo' => 'S10047',
];

try {
    //只需调用一个接口即可
    $returnData = RemoteHelper::index($privateKey, $publicKey, $merchantNo, $data, $url);

    var_dump($returnData);
} catch (Exception $e) {
    var_dump($e->getCode() . "::" . $e->getMessage());
}

```

## 调用方式一特别说明
```
为了方便查看日志，本sdk添加了此功能，日志目录：/data/log，文件名称为php_sdk_年月日.log，如php_sdk_20221012.log
如果有报错如：failed to open stream: No such file or directory，那需要您手动创建目录：/data/log
```

## 调用方式二（v2版本未更新，调用复杂，不推荐）

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
     * 这里声明的目的是为了 IDE (如 PhpStorm) 语法提示
     * @var AccInfoResponse $objResultResp
     */
    $objResultResp = $objClientResp->fetchResult();

    var_dump($objResultResp->getBalance());
} catch (Exception $e) {
    var_dump($e->getCode() . "::" . $e->getMessage());
}

```

# 接口（只适用于旧版本。v2版本不可用，不推荐）

| API             | 请求类                   | 响应类                    |
|-----------------|-----------------------|------------------------|
| 用户注册            | UserRegisterRequest::class | UserRegisterResponse::class |
| 用户信息查询          | UserQueryRequest::class | UserQueryResponse::class |
| 用户信息变更 - 注册手机号  | UserUpdatePhoneRequest::class | UserUpdateResponse::class |
| 用户信息变更 - 影像件    | UserUpdateImageRequest::class | UserUpdateResponse::class |
| 用户信息变更 - 拓展业务类型 | UserUpdateExpandRequest::class | UserUpdateResponse::class |
| 用户信息变更 - 结算卡信息  | UserUpdateCardRequest::class | UserUpdateResponse::class |
| 用户账户开户          | UserOpenRequest::class | UserOpenResponse::class |
| 用户账户开户（活体认证）    | UserOpenVideoRequest::class | UserOpenResponse::class |
| 订单支付            | OrderPayRequest::class  | OrderPayResponse::class |
| 批次订单号查询订单       | OrderQueryBatchRequest::class  | OrderQueryBatchResponse::class |
| 子订单详情查询         | OrderQueryDetailRequest::class | OrderQueryDetailResponse::class |
| 商户信息查询          | AccInfoRequest::class | AccInfoResponse::class |
