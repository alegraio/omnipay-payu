<?php
/**
 * PayU Class using API
 */

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\PayU\Messages\CompleteAuthorizeRequest;
use Omnipay\PayU\Messages\RefundRequest;
use Omnipay\PayU\Messages\CardInfoV1Request;
use Omnipay\PayU\Messages\OrderTransactionRequest;
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
 * @method \Omnipay\Common\Message\RequestInterface fetchTransaction(array $options = [])
 */
class PayUGateway extends AbstractGateway
{

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     * @return string
     */
    public function getName()
    {
        return 'PayU';
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
    public function setClientId(string $value)
    {
        return $this->setParameter('clientId', $value);
    }


    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function completeAuthorize(array $parameters = [])
    {
        return $this->createRequest(CompleteAuthorizeRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest(RefundRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function cardInfoV1(array $parameters = [])
    {
        return $this->createRequest(CardInfoV1Request::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function orderTransaction(array $parameters = [])
    {
        return $this->createRequest(OrderTransactionRequest::class, $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function cardInfoV2(array $parameters = [])
    {
        return $this->createRequest(CardInfoV2Request::class, $parameters);
    }

    /**
     * @param string $value
     * @return PayUGateway
     */
    public function setSecret(string $value)
    {
        return $this->setParameter('secret', $value);
    }
}
