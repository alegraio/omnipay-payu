<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\PurchaseInfoRequest;

class PurchaseInfoRequestTest extends PayUTestCase
{
    /**
     * @var PurchaseInfoRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new PurchaseInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPurchaseInfoParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/order/ios.php',
            $this->request->getEndpoint());
    }

    public function testOrderReference(): void
    {
        $this->request->setOrderRef('NYX14792147');

        self::assertSame('NYX14792147', $this->request->getOrderRef());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseInfoSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/order/ios.php',
            $this->request->getEndpoint());
        self::assertSame('COMPLETE', $response->getData()['ORDER_STATUS']);
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseInfoFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/order/ios.php',
            $this->request->getEndpoint());
        self::assertSame('NOT_FOUND', $response->getData()['ORDER_STATUS']);
    }
}