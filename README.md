# omnipay-payu
<p>
<a href="https://github.com/alegraio/omnipay-payu/actions"><img src="https://github.com/alegraio/omnipay-payu/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/alegra/omnipay-payu"><img src="https://img.shields.io/packagist/dt/alegra/omnipay-payu" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/alegra/omnipay-payu"><img src="https://img.shields.io/packagist/v/alegra/omnipay-payu" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/alegra/omnipay-payu"><img src="https://img.shields.io/packagist/l/alegra/omnipay-payu" alt="License"></a>
</p>
Payu gateway for Omnipay V3 payment processing library

<a href="https://github.com/thephpleague/omnipay">Omnipay</a> is a framework agnostic, multi-gateway payment
processing library for PHP 7.3+. This package implements PayU Online Payment Gateway support for Omnipay.

<p>PayU ALU V3 API <a href="https://payuturkiye.github.io/PayU-Turkiye-Entegrasyon-Dokumani/#alu-v3-api-entegrasyonu" rel="nofollow">documentation</a></p>



## Requirement
* PHP >= 7.3.x,
* [Omnipay V.3](https://github.com/thephpleague/omnipay) repository,
* PHPUnit to run tests

## Autoload

We have to install omnipay V.3
```bash
composer require league/omnipay:^3
```

Then we have to install omnipay-payu package:
```bash
composer require alegra/omnipay-payu
```

> `payment-payu` follows the PSR-4 convention names for its classes, which means you can easily integrate `payment-payu` classes loading in your own autoloader.

## Basic Usage

- You have to download /examples folder. 
- You have to composer install:
```bash
composer install
```


**Purchase Example**
- You can check purchase.php file  in /examples folder. 

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getPurchaseParams();
$response = $gateway->purchase($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'redirect' => $response->isRedirect() ?: 0,
    'message' => $response->getMessage(),
    'transactionId' => $response->getTransactionReference(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

**Purchase 3d Example**
- You can check purchase3d.php file  in /examples folder. 

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getPurchase3dParams();
$response = $gateway->purchase($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'redirect' => $response->isRedirect() ?: 0,
    'redirectUrl' => $response->getRedirectUrl() ?: null,
    'message' => $response->getMessage(),
    'transactionId' => $response->getTransactionReference(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

**Confirmation Service Example**
- You can check completeAuthorize.php file  in /examples folder. 
- The confirmation service is only for merchants working on the pre-motorization model, you can go with your sales representative for detailed information.

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getCompleteAuthorizeParams();
$response = $gateway->completeAuthorize($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'message' => $response->getMessage(),
    'transactionId' => $response->getTransactionReference(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

**Refund Example**
- You can check refund.php file  in /examples folder. 

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getRefundParams();
$response = $gateway->refund($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'message' => $response->getMessage(),
    'transactionId' => $response->getTransactionReference(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

**Fetch Transaction Example**
- You can check fetchTransaction.php file  in /examples folder. 

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getFetchTransactionParams();
$response = $gateway->fetchTransaction($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'message' => $response->getMessage(),
    'transactionId' => $response->getTransactionReference(),
    'orderReferenceNo' => $response->getOrderReferenceNoExt(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

**Card Information V1 Example**
- You can check cardInfoV1.php file  in /examples folder. 

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getCardInfoV1Params();
$response = $gateway->cardInfoV1($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'message' => $response->getMessage(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

**Card Information V2 Example**
- You can check cardInfoV2.php file  in /examples folder. 

```php
<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getCardInfoV2Params();
$response = $gateway->cardInfoV2($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'message' => $response->getMessage(),
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");
```

requestParams: 

> System send request to payU api. It shows request information. 
>

## Licensing
[GNU General Public Licence v3.0](LICENSE)

    For the full copyright and license information, please view the LICENSE
    file that was distributed with this source code.