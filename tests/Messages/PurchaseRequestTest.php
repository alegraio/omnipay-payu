<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\PurchaseRequest;

class PurchaseRequestTest extends PayUTestCase
{
    /**
     * @var PurchaseRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPurchaseParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/order/alu/v3', $this->request->getEndpoint());
    }

    public function testOrderReference(): void
    {
        self::assertArrayNotHasKey('orderRef', $this->request->getData());

        $this->request->setOrderRef('181683681');

        self::assertSame('181683681', $this->request->getOrderRef());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://secure.payu.com.tr/order/alu/v3', $this->request->getEndpoint());
        self::assertSame('181712758', $response->getTransactionReference());
    }

    public function testSendWithDiscountSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseWithDiscountSuccess.txt');

        $params = $this->getPurchaseWithDiscountParams();
        $this->request->initialize($params);

        $requestData = $this->request->getData();

        $amountCalculated = 0;
        foreach ($requestData['ORDER_PRICE'] as $orderPriceKey => $orderPrice) {
            $amountCalculated += (int)$orderPrice * (int)$requestData['ORDER_QTY'][$orderPriceKey];
        }
        $amountCalculated -= $requestData['DISCOUNT'];
        $response = $this->request->send();
        $amountApplied = (int)$response->getData()['AMOUNT'];

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://secure.payu.com.tr/order/alu/v3', $this->request->getEndpoint());
        self::assertSame('187146704', $response->getTransactionReference());
        self::assertSame((int)$amountCalculated, $amountApplied);
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertNull($response->getTransactionReference());
        self::assertSame('https://secure.payu.com.tr/order/alu/v3', $this->request->getEndpoint());
        self::assertSame('DUPLICATE_ORDER', $response->getCode());
        self::assertSame('The order with reference 181712758 is already paid or in the process of being approved. A new payment is not necessary.',
            $response->getMessage());
    }
}