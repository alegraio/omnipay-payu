<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\CardInfoV1Request;
use Omnipay\PayU\Messages\CardInfoV2Request;

class CardInfoV2RequestTest extends PayUTestCase
{
    /**
     * @var CardInfoV2Request
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new CardInfoV2Request($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCardInfoV2Params());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/api/card-info/v2/', $this->request->getEndpoint());
    }

    public function testCardNumber(): void
    {
        $this->request->setNumber('4355084355084358');

        self::assertSame('4355084355084358', $this->request->getNumber());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CardInfoV2Success.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/api/card-info/v2/', $this->request->getEndpoint());
        self::assertSame(200, $response->getCode());
        self::assertSame('VISA', $response->getCardBinType());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CardInfoV2Failure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/api/card-info/v2/', $this->request->getEndpoint());
        self::assertSame(401, $response->getCode());
        self::assertSame('Invalid CVV2/CVC2 code.', $response->getMessage());
    }
}