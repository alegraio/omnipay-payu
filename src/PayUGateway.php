<?php
/**
 * Payu Class using API
 */

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\RequestInterface;


/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
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
        return $this->createRequest('\Omnipay\PayU\Messages\PurchaseRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function completeAuthorize(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\CompleteAuthorizeRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\RefundRequest', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function cardInfoV1(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\CardInfoV1Request', $parameters);
    }

    /**
     * @param array $parameters
     * @return AbstractRequest|RequestInterface
     */
    public function orderTransaction(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\OrderTransactionRequest', $parameters);
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
