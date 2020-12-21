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
