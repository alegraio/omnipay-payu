<?php
/**
 * PayU Class using API
 */

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\PayU\Messages\CompleteAuthorizeRequest;
use Omnipay\PayU\Messages\PurchaseInfoRequest;
use Omnipay\PayU\Messages\PurchaseReportRequest;
use Omnipay\PayU\Messages\RefundRequest;
use Omnipay\PayU\Messages\CardInfoV1Request;
use Omnipay\PayU\Messages\FetchTransactionRequest;
use Omnipay\PayU\Messages\CardInfoV2Request;
use Omnipay\PayU\Messages\PurchaseRequest;


/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 * @method \Omnipay\Common\Message\NotificationInterface acceptNotification(array $options = array())
 */
class PayUGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName(): string
    {
        return 'PayU';
    }

    /**
     * Default parameters.
     *
     * @return array
     */
    public function getDefaultParameters(): array
    {
        return [
            'clientId' => '',
            'secret' => '',
        ];
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getParameter('secret');
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    /**
     * @param string $value
     * @return PayUGateway
     */
    public function setClientId(string $value): PayUGateway
    {
        return $this->setParameter('clientId', $value);
    }


    /**
     * @param array $parameters
     * @return PurchaseRequest|RequestInterface
     */
    public function purchase(array $parameters = []): PurchaseRequest
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return CompleteAuthorizeRequest|RequestInterface
     */
    public function completeAuthorize(array $parameters = []): CompleteAuthorizeRequest
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return RefundRequest|RequestInterface
     */
    public function refund(array $parameters = []): RefundRequest
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return CardInfoV1Request|RequestInterface
     */
    public function cardInfoV1(array $parameters = []): CardInfoV1Request
    {
        return $this->createRequest(CardInfoV1Request::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return PurchaseReportRequest|RequestInterface
     */
    public function purchaseReport(array $parameters = []): PurchaseReportRequest
    {
        return $this->createRequest(PurchaseReportRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return FetchTransactionRequest|RequestInterface
     */
    public function fetchTransaction(array $parameters = []): FetchTransactionRequest
    {
        return $this->createRequest(FetchTransactionRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return CardInfoV2Request|RequestInterface
     */
    public function cardInfoV2(array $parameters = []): CardInfoV2Request
    {
        return $this->createRequest(CardInfoV2Request::class, $parameters);
    }

    /**
     * @param string $value
     * @return PayUGateway
     */
    public function setSecret(string $value): PayUGateway
    {
        return $this->setParameter('secret', $value);
    }
}
