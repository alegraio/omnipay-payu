<?php

namespace Omnipay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\Messages\AuthorizeResponse;
use Omnipay\PayU\Messages\CompletePurchaseResponse;
use Omnipay\PayU\Messages\RefundResponse;
use Omnipay\PayU\PayUGateway;
use Omnipay\PayU\PayUItemBag;


class GatewayTest extends GatewayTestCase
{
    /** @var PayUGateway */
    public $gateway;

    /** @var array */
    public $options;

    public function setUp()
    {
        /** @var PayUGateway gateway */
        $this->gateway = new PayUGateway(null, $this->getHttpRequest());
        $this->gateway->setSecret('f*%J7z6_#|5]s7V4[g3]');
        $this->gateway->setClientId('PALJZXGV');
    }

    public function testPurchase()
    {
        $products = [
            [
                'name' => 'TestYILYIL',
                'sku' => 'Test9876543',
                'description' => 'testtets',
                'quantity' => "10",
                'price' => "10",
                'price_type' => 'with_vat'
            ],
            [
                'name' => 'TestYILYIL1',
                'sku' => 'Test98765431',
                'description' => 'testtets1',
                'quantity' => "3",
                'price' => "50",
                'price_type' => 'with_vat'
            ]
        ];

        $allItem = new PayUItemBag();
        foreach ($products as $product) {
            $allItem->add($product);
        }

        $cardInfo = $this->getValidCard();
        $cardInfo['number'] = '5571135571135575';
        $cardInfo['expiryMonth'] = "12";
        $cardInfo['expiryYear'] = "2022";
        $cardInfo['cvv'] = "000";
        $card = new CreditCard($cardInfo);
        $card->setEmail("mail@mail.com");

        $this->options = [
            'card' => $card,
            'orderRef' => '252343532',
            'paymentMethod' => 'credit_card',
            'installmentNumber' => "1",
            'ccOwner' => '000',
            'returnUrl' => "www.backref.com.tr",
            'items' => $allItem
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testCompletePurchase()
    {

        $this->options = [
            'orderRef' => '452584931',
            'idnDate' => date('Y-m-d H:i:s', time()),
            'amount' => '250'
        ];

        /** @var CompletePurchaseResponse $response */
        $response = $this->gateway->completePurchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());
    }

    public function testRefund()
    {
        $this->options = [
            'orderRef' => '152584931',
            'orderAmount' => '250',
            'irnDate' => date('Y-m-d H:i:s.0', time()),
            'amount' => '50'
        ];

        /** @var RefundResponse $response */
        $response = $this->gateway->refund($this->options)->send();
        $this->assertTrue($response->isSuccessful());
    }
}
