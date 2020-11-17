<?php

namespace OmnipayTest\PayU;

use Omnipay\PayU\Messages\CardInfoV1Request;
use Omnipay\PayU\Messages\CardInfoV2Request;
use Omnipay\PayU\Messages\CompleteAuthorizeRequest;
use Omnipay\PayU\Messages\FetchTransactionRequest;
use Omnipay\PayU\Messages\PurchaseRequest;
use Omnipay\PayU\Messages\RefundRequest;
use Omnipay\PayU\PayUGateway;
use Omnipay\Tests\GatewayTestCase;

class PayUGatewayTest extends GatewayTestCase
{
    public function setUp(): void
    {
        $this->gateway = new PayUGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase(): void
    {
        /** @var PurchaseRequest $request */
        $request = $this->gateway->purchase(['orderRef' => '41838239']);

        self::assertInstanceOf(PurchaseRequest::class, $request);
        self::assertSame('41838239', $request->getOrderRef());
    }

    public function testCompleteAuthorize(): void
    {
        /** @var CompleteAuthorizeRequest $request */
        $request = $this->gateway->completeAuthorize(['orderRef' => '41838239']);

        self::assertInstanceOf(CompleteAuthorizeRequest::class, $request);
        self::assertSame('41838239', $request->getOrderRef());
    }

    public function testCardInfoV1(): void
    {
        /** @var CardInfoV1Request $request */
        $request = $this->gateway->cardInfoV1(['bin' => '557829']);

        self::assertInstanceOf(CardInfoV1Request::class, $request);
        self::assertSame('557829', $request->getBin());
    }

    public function testCardInfoV2(): void
    {
        /** @var CardInfoV2Request $request */
        $request = $this->gateway->cardInfoV2(['clientId' => '34353']);

        self::assertInstanceOf(CardInfoV2Request::class, $request);
        self::assertSame('34353', $request->getClientId());
    }

    public function testRefund(): void
    {
        /** @var RefundRequest $request */
        $request = $this->gateway->refund(['orderRef' => '41838239']);

        self::assertInstanceOf(RefundRequest::class, $request);
        self::assertSame('41838239', $request->getOrderRef());
    }

    public function testFetchTransaction(): void
    {
        /** @var FetchTransactionRequest $request */
        $request = $this->gateway->fetchTransaction(['refNoExt' => '784']);

        self::assertInstanceOf(FetchTransactionRequest::class, $request);
        self::assertSame('784', $request->getRefNoExt());
    }
}