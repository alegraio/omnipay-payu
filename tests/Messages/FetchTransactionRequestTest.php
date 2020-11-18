<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\CompleteAuthorizeRequest;
use Omnipay\PayU\Messages\FetchTransactionRequest;

class FetchTransactionRequestTest extends PayUTestCase
{
    /**
     * @var FetchTransactionRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new FetchTransactionRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getFetchTransactionParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/order/ios.php', $this->request->getEndpoint());
    }

    public function testOrderReference(): void
    {
        self::assertArrayNotHasKey('refNoExt', $this->request->getData());

        $this->request->setRefNoExt('1817127587777');

        self::assertSame('1817127587777', $this->request->getRefNoExt());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('FetchTransactionSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/order/ios.php', $this->request->getEndpoint());
        self::assertSame('181726705', $response->getTransactionReference());
        self::assertSame('181712758', $response->getOrderReferenceNoExt());
    }

    public function testSendTransactionStatus(): void
    {
        $this->setMockHttpResponse('FetchTransactionFailure.txt');
        $response = $this->request->send();

        self::assertSame('-', $response->getTransactionReference());
        self::assertSame('-', $response->getOrderReferenceNoExt());
        self::assertSame('https://secure.payu.com.tr/order/ios.php', $this->request->getEndpoint());
        self::assertSame('NOT_FOUND', $response->getMessage());
    }
}