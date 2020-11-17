<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\CompleteAuthorizeRequest;
use Omnipay\PayU\Messages\RefundRequest;

class RefundRequestTest extends PayUTestCase
{
    /**
     * @var CompleteAuthorizeRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getRefundParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/order/irn.php', $this->request->getEndpoint());
    }

    public function testOrderReference(): void
    {
        self::assertArrayNotHasKey('orderRef', $this->request->getData());

        $this->request->setOrderRef('181683681');

        self::assertSame('181683681', $this->request->getOrderRef());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('RefundSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://secure.payu.com.tr/order/irn.php', $this->request->getEndpoint());
        self::assertSame('41854324', $response->getTransactionReference());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('RefundFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertFalse($response->isRedirect());
        self::assertSame('https://secure.payu.com.tr/order/irn.php', $this->request->getEndpoint());
        self::assertSame('Invalid ORDER_REF', $response->getMessage());
    }
}