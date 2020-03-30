<?php
/**
 * Payu Class using API
 */

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\RequestInterface;


/**
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = array())
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = array())
 */
class Gateway extends AbstractGateway
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
     * @return Gateway
     */
    public function setClientId(string $value)
    {
        return $this->setParameter('clientId', $value);
    }


    /**
     * @param array $parameters
     * @return \Omnipay\Common\Message\AbstractRequest|RequestInterface
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\PayU\Messages\PurchaseRequest', $parameters);
    }

    /**
     * @param string $value
     * @return Gateway
     */
    public function setSecret(string $value)
    {
        return $this->setParameter('secret', $value);
    }


}
