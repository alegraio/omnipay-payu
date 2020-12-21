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
