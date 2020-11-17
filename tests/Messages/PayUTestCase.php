<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\PayUItemBag;
use Omnipay\Tests\TestCase;

class PayUTestCase extends TestCase
{
    protected function getPurchaseParams(): array
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
        $params = [
            'card' => $card,
            'orderRef' => '12823076',
            'paymentMethod' => 'credit_card',
            'installmentNumber' => '1',
            'ccOwner' => '000',
            'returnUrl' => "www.backref.com.tr",
            'items' => $allItem
        ];

        return $this->provideMergedParams($params);
    }

    protected function getRefundParams(): array
    {
        $params = [
            'paymentTransactionId' => '12823076',
            'clientIp' => '11.11.11.111',
            'amount' => '10'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCancelPurchaseParams(): array
    {
        $params = [
            'paymentId' => '13292709',
            'clientIp' => '11.11.11.111'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCompletePurchaseParams(): array
    {
        $params = [
            'paymentId' => '13292709',
        ];

        return $this->provideMergedParams($params);
    }

    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'secret' => 'SECRET_KEY',
            'clientId' => 'OPU_TEST',
        ];
    }

    private function provideMergedParams($params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }
}