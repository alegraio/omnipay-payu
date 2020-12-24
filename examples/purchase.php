<?php

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->addPsr4('Examples\\', __DIR__);

use Omnipay\PayU\PayUGateway;
use Examples\Helper;

$gateway = new PayUGateway();

$helper = new Helper();
try {
    $params = $helper->getPurchaseParams();
} catch (Exception $e) {
    throw new \RuntimeException($e->getMessage());
}
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
