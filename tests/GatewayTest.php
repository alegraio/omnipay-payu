<?php

namespace Omnipay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\Messages\AuthorizeResponse;
use Omnipay\PayU\Messages\Item;
use Omnipay\PayU\PayUGateway;


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
        $this->gateway = new PayUGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setSecret('SECRET_KEY');
        $this->gateway->setClientId('OPU_TEST');
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
        $cardInfo['number'] = '4355084355084358';
        $cardInfo['expiryMonth'] = "12";
        $cardInfo['expiryYear'] = "2022";
        $cardInfo['cvv'] = "000";
        $card = new CreditCard($cardInfo);
        $card->setEmail("mail@mail.com");
        $card->setShippingCompany('test');

        $items = new Item();
        foreach ($products as $product) {
            $items->setName($product['name']);
            $items->setPrice($product['price']);
            $items->setQuantity($product['quantity']);
            $items->setDescription($product['description']);
            $items->setParameter('sku', $product['sku']);
            $items->setParameter('price_type', $product['price_type']);
        }

        $this->options = [
            'card' => $card,
            'orderRef' => '1241040404',
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
