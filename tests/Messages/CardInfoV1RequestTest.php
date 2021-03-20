<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\CardInfoV1Request;

class CardInfoV1RequestTest extends PayUTestCase
{
    /**
     * @var CardInfoV1Request
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new CardInfoV1Request($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getCardInfoV1Params());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/api/card-info/v1/' . $this->request->getBin(),
            $this->request->getEndpoint());
    }

    public function testOrderReference(): void
    {
        $this->request->setBin('7777');

        self::assertSame('7777', $this->request->getBin());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('CardInfoV1Success.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/api/card-info/v1/' . $this->request->getBin(),
            $this->request->getEndpoint());
        self::assertSame('MASTERCARD', $response->getCardBinType());
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('CardInfoV1Failure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertSame('https://secure.payu.com.tr/api/card-info/v1/' . $this->request->getBin(),
            $this->request->getEndpoint());
        self::assertSame('20000001', $response->getCode());
        self::assertSame('cardBin is required and should be numeric.', $response->getMessage());
    }
}