<?php

namespace OmnipayTest\PayU\Messages;

use Omnipay\PayU\Messages\PurchaseReportRequest;

class PurchaseReportRequestTest extends PayUTestCase
{
    /**
     * @var PurchaseReportRequest
     */
    private $request;

    public function setUp(): void
    {
        $this->request = new PurchaseReportRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize($this->getPurchaseReportParams());
    }

    public function testEndpoint(): void
    {
        self::assertSame('https://secure.payu.com.tr/reports/orders',
            $this->request->getEndpoint());
    }

    public function testStartDate(): void
    {
        $this->request->setStartDate('2020-01-01');

        self::assertSame('2020-01-01', $this->request->getStartDate());
    }

    public function testEndDate(): void
    {
        $this->request->setEndDate('2020-01-01');

        self::assertSame('2020-01-01', $this->request->getEndDate());
    }

    public function testSendSuccess(): void
    {
        $this->setMockHttpResponse('PurchaseReportSuccess.txt');
        $response = $this->request->send();

        self::assertTrue($response->isSuccessful());
        self::assertSame('Success', $response->getData()['statusDescription']);
    }

    public function testSendError(): void
    {
        $this->setMockHttpResponse('PurchaseReportFailure.txt');
        $response = $this->request->send();

        self::assertFalse($response->isSuccessful());
        self::assertSame('3', $response->getData()['statusCode']);
    }
}