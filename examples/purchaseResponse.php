<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
$params = $helper->getPurchaseReportParams();
$response = $gateway->purchaseReport($params)->send();

$result = [
    'status' => $response->isSuccessful() ?: 0,
    'requestParams' => $response->getServiceRequestParams(),
    'response' => $response->getData()
];

print("<pre>" . print_r($result, true) . "</pre>");