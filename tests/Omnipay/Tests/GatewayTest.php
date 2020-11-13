<?php

namespace Omnipay\Tests;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\Messages\AuthorizeResponse;
use Omnipay\PayU\Messages\CardInfoV1Response;
use Omnipay\PayU\Messages\CardInfoV2Response;
use Omnipay\PayU\Messages\CompleteAuthorizeResponse;
use Omnipay\PayU\Messages\OrderTransactionResponse;
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
        $this->gateway->setSecret('SECRET_KEY');
        $this->gateway->setClientId('OPU_TEST');
    }

    public function testPurchase()
    {
        $orderRef = uniqid('alegra', false);

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
            'orderRef' => $orderRef,
            'paymentMethod' => 'credit_card',
            'installmentNumber' => "1",
            'ccOwner' => '000',
            'returnUrl' => "www.backref.com.tr",
            'items' => $allItem
        ];

        /** @var AuthorizeResponse $response */
        $response = $this->gateway->purchase($this->options)->send();
        $data = $response->getData();
        self::assertTrue($response->isSuccessful());
        return $data['REFNO'];
    }


    public function testCompleteAuthorize()
    {
        $this->options = [
            'orderRef' => '41838239',
            'amount' => '10.90'
        ];

        /** @var CompleteAuthorizeResponse $response */
        $response = $this->gateway->completeAuthorize($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    /**
     * @depends testPurchase
     * @param $refNo
     */
    public function testRefund($refNo): void
    {
        $this->options = [
            'orderRef' => $refNo,
            'orderAmount' => '250',
            'amount' => '50'
        ];

        /** @var RefundResponse $response */
        $response = $this->gateway->refund($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testCardInfoV1(): void
    {
        $this->options = [
            'bin' => '557829'
        ];

        /** @var CardInfoV1Response $response */
        $response = $this->gateway->cardInfoV1($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testOrderTransaction(): void
    {
        $this->options = [
            'refNoExt' => '7304'
        ];

        /** @var OrderTransactionResponse $response */
        $response = $this->gateway->orderTransaction($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }

    public function testCardInfoV2(): void
    {
        $this->options = [
            'cvv' => '000',
            'owner' => 'Mesut GÜMÜŞTAŞ',
            "expYear" => "2020",
            "expMonth" => "12",
            "number" => "4355084355084358"
        ];

        /** @var CardInfoV2Response $response */
        $response = $this->gateway->cardInfoV2($this->options)->send();
        self::assertTrue($response->isSuccessful());
    }
}
