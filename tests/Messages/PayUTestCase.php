<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\Common\CreditCard;
use Omnipay\PayU\PayUItemBag;
use Omnipay\Tests\TestCase;

class PayUTestCase extends TestCase
{
    protected function getPurchaseParams(): array
    {
        $params = $this->getDefaultPurchaseParams();

        return $this->provideMergedParams($params);
    }

    protected function getPurchase3dParams(): array
    {
        $params = $this->getDefaultPurchaseParams();

        return array_merge($params, $this->getPurchase3dDefaultOptions());
    }

    protected function getRefundParams(): array
    {
        $params = [
            'orderRef' => 'alegra5fb3d705f0cf0',
            'orderAmount' => '250',
            'amount' => '50'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCompleteAuthorizeParams(): array
    {
        $params = [
            'orderRef' => '41838239',
            'amount' => '10.90'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getFetchTransactionParams(): array
    {
        $params = [
            'refNoExt' => '1817127587777'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCardInfoV1Params(): array
    {
        $params = [
            'bin' => '557829'
        ];

        return $this->provideMergedParams($params);
    }

    protected function getCardInfoV2Params(): array
    {
        $params = [
            'cvv' => '000',
            'owner' => 'Mesut GÜMÜŞTAŞ',
            "expYear" => "2020",
            "expMonth" => "12",
            "number" => "4355084355084358"
        ];

        return $this->provideMergedParams($params);
    }


    private function getDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'secret' => 'SECRET_KEY',
            'clientId' => 'OPU_TEST'
        ];
    }

    private function getPurchase3dDefaultOptions(): array
    {
        return [
            'testMode' => true,
            'secret' => 'f*%J7z6_#|5]s7V4[g3]',
            'clientId' => 'PALJZXGV'
        ];
    }

    private function provideMergedParams($params): array
    {
        $params = array_merge($params, $this->getDefaultOptions());
        return $params;
    }

    protected function getDefaultPurchaseParams(): array
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

        return $params;
    }
}