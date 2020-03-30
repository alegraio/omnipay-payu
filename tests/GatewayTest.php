<?php

namespace Omnipay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\Gateway;


class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    public $gateway;

    /** @var array */
    public $options;

    /** @var array */
    public $subscription_options;

    public function setUp()
    {
        /** @var Gateway gateway */
        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setSecret('SECRET_KEY');
        $this->gateway->setClientId('OPU_TEST');
    }

    public function testPurchase()
    {
        $items = [
            [
                'name' => 'Test1',
                'sku' => 'Test9876543',
                'description' => 'testtets',
                'quantity' => 10,
                'price' => 10,
                'price_type' => 'with_vat'
            ]
        ];
        $cardInfo = $this->getValidCard();
        $cardInfo['number'] = '4355084355084358';
        $cardInfo['expiryMonth'] = 12;
        $cardInfo['expiryYear'] = 2022;
        $cardInfo['cvv'] = 000;
        $card = new CreditCard($cardInfo);
        $this->options = [
            'card' => $card,
            'orderRef' => '1000000000',
            'paymentMethod' => 'credit_card',
            'item' => $items
        ];


        $response = $this->gateway->purchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());

    }
}
