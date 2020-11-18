<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\CompleteAuthorizeRequest;

class CompleteAuthorizeRequestTest extends PayUTestCase
{
    /**
     * @var CompleteAuthorizeRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new CompleteAuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCompleteAuthorizeParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/order/idn.php', $this->request->getEndpoint());
    }

    public function testOrderReference(): void
    {
        self::assertArrayNotHasKey('orderRef', $this->request->getData());

        $this->request->setOrderRef('181683681');

        self::assertSame('181683681', $this->request->getOrderRef());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CompleteAuthorizeSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://secure.payu.com.tr/order/idn.php', $this->request->getEndpoint());
        self::assertSame('alegra5fb3d705f0cf0', $response->getTransactionReference());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CompleteAuthorizeFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://secure.payu.com.tr/order/idn.php', $this->request->getEndpoint());
        self::assertSame('2', $response->getCode());
        self::assertSame('ORDER_REF missing or incorrect', $response->getMessage());
    }
}