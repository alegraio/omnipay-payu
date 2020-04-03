<?php

namespace Omnipay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\Messages\AuthorizeResponse;
use Omnipay\PayU\PayUGateway;
use Omnipay\PayU\PayUItem;


class GatewayTest extends GatewayTestCase
{
    /** @var PayUGateway */
    public $gateway;

    /** @var array */
    public $options;

    /** @var array */
    public $subscription_options;

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
            ]
        ];

        $cardInfo = $this->getValidCard();
        $cardInfo['number'] = '5571135571135575';
        $cardInfo['expiryMonth'] = "12";
        $cardInfo['expiryYear'] = "2022";
        $cardInfo['cvv'] = "000";
        $card = new CreditCard($cardInfo);
        $card->setEmail("mail@mail.com");
        $card->setShippingCompany('test');
        $card->setBillingFax('02123234534');

        $items = new PayUItem();
        foreach ($products as $product) {
            $items->setName($product['name']);
            $items->setPrice($product['price']);
            $items->setQuantity($product['quantity']);
            $items->setDescription($product['description']);
            $items->setSku($product['sku']);
            $items->setPriceType($product['price_type']);
        }

        $this->options = [
            'card' => $card,
            'orderRef' => '992040404',
            'paymentMethod' => 'credit_card',
            'items' => [$items],
            'installmentNumber' => "1",
            'ccOwner' => '000'
        ];


        /** @var AuthorizeResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertTrue($response->isSuccessful());
    }
}
