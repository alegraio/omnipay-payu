<?php

namespace Examples;

use Exception;
use Omnipay\PayU\PayUItemBag;
use Omnipay\Common\CreditCard;

class Helper
{

    /**
     * @return array
     * @throws Exception
     */
    public function getPurchaseParams(): array
    {
        $params = $this->getDefaultPurchaseParams();

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     */
    public function getPurchaseInfoParams(): array
    {
        $params = [
            'orderRef' => 'NYX14792147'
        ];

        return $this->provideMergedParams($params);
    }

    public function getPurchaseReportParams(): array
    {
        $params = [
            'startDate' => '2020-01-01',
            'endDate' => '2020-01-02'
        ];

        return $this->provideMergedParams($params);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getPurchase3dParams(): array
    {
        $params = $this->getDefaultPurchaseParams();

        return array_merge($params, $this->getPurchase3dDefaultOptions());
    }

    public function getRefundParams(): array
    {
        $params = [
            'orderRef' => 'alegra5fb3d705f0cf0',
            'orderAmount' => '250',
            'amount' => '50'
        ];

        return $this->provideMergedParams($params);
    }

    public function getCompleteAuthorizeParams(): array
    {
        $params = [
            'orderRef' => '181683681',
            'amount' => '10.90'
        ];

        return $this->provideMergedParams($params);
    }

    public function getFetchTransactionParams(): array
    {
        $params = [
            'refNoExt' => '181683681'
        ];

        return $this->provideMergedParams($params);
    }

    public function getCardInfoV1Params(): array
    {
        $params = [
            'bin' => '557829'
        ];

        return $this->provideMergedParams($params);
    }

    public function getCardInfoV2Params(): array
    {
        $params = [
            'cvv' => '000',
            'owner' => 'Test Name',
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

    /**
     * @return array
     * @throws Exception
     */
    private function getDefaultPurchaseParams(): array
    {
        $products = [
            [
                'name' => 'Test',
                'sku' => 'Test123',
                'description' => 'testDesc',
                'quantity' => '10',
                'price' => '10',
                'price_type' => 'with_vat'
            ]
        ];

        $allItem = new PayUItemBag();
        foreach ($products as $product) {
            $allItem->add($product);
        }

        $cardInfo = $this->getValidCard();
        $cardInfo['number'] = '5571135571135575';
        $cardInfo['expiryMonth'] = '12';
        $cardInfo['expiryYear'] = '2022';
        $cardInfo['cvv'] = '000';
        $card = new CreditCard($cardInfo);
        $card->setEmail('mail@mail.com');
        return [
            'card' => $card,
            'orderRef' => '445576',
            'paymentMethod' => 'credit_card',
            'installmentNumber' => '1',
            'ccOwner' => '000',
            'returnUrl' => "www.backref.com.tr",
            'items' => $allItem
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function getValidCard(): array
    {
        return [
            'firstName' => 'Example',
            'lastName' => 'User',
            'number' => '4111111111111111',
            'expiryMonth' => random_int(1, 12),
            'expiryYear' => gmdate('Y') + random_int(1, 5),
            'cvv' => random_int(100, 999),
            'billingAddress1' => '123 Billing St',
            'billingAddress2' => 'Billsville',
            'billingCity' => 'Billstown',
            'billingPostcode' => '12345',
            'billingState' => 'CA',
            'billingCountry' => 'US',
            'billingPhone' => '(555) 123-4567',
            'shippingAddress1' => '123 Shipping St',
            'shippingAddress2' => 'Shipsville',
            'shippingCity' => 'Shipstown',
            'shippingPostcode' => '54321',
            'shippingState' => 'NY',
            'shippingCountry' => 'US',
            'shippingPhone' => '(555) 987-6543',
        ];
    }
}

