<?php
/**
 * PayU Card Info V2 Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class CardInfoV2Response extends AbstractResponse implements RedirectResponseInterface
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
        $content = !empty($this->getData()) ? json_decode($this->getData(), true) : array();
        $this->setData($content);
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getMessage() === 'success';
    }

    public function getMessage()
    {
        if (!empty($this->getData()['meta']) && !empty($this->getData()['meta']['message'])) {
            return $this->getData()['meta']['message'];
        }

        return null;
    }

    public function getCode()
    {
        if (!empty($this->getData()['meta']) && !empty($this->getData()['meta']['code'])) {
            return $this->getData()['meta']['code'];
        }

        return $this->statusCode;
    }

    /**
     * @return array
     */
    public function getCardInfo()
    {
        if (!empty($this->getData()['cardInfo'])) {
            return $this->getData()['cardInfo'];
        }

        return [];
    }

    /**
     * @return mixed|null
     */
    public function getCardNumber()
    {
        if (!empty($this->getCardInfo()['cardMask'])) {
            return $this->getCardInfo()['cardMask'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardBinNumber()
    {
        if (!empty($this->getCardInfo()['binNumber'])) {
            return $this->getCardInfo()['binNumber'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardBinType()
    {
        if (!empty($this->getCardInfo()['cardBrand'])) {
            return $this->getCardInfo()['cardBrand'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardBinIssuer()
    {
        if (!empty($this->getCardInfo()['issuerBank'])) {
            return $this->getCardInfo()['issuerBank'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardType()
    {
        if (!empty($this->getCardInfo()['cardType'])) {
            return $this->getCardInfo()['cardType'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardProfile()
    {
        if (!empty($this->getCardInfo()['cardProfile'])) {
            return $this->getCardInfo()['cardProfile'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardCountry()
    {
        if (!empty($this->getCardInfo()['issuerCountry'])) {
            return $this->getCardInfo()['issuerCountry'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardProgram()
    {
        if (!empty($this->getCardInfo()['cardProgram'])) {
            return $this->getCardInfo()['cardProgram'];
        }

        return null;
    }

    /**
     * @return mixed|mixed
     */
    public function getCardInstallmentOptions()
    {
        if (!empty($this->getCardInfo()['installmentOptions'])) {
            return $this->getCardInfo()['installmentOptions'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardLoyaltyPoints()
    {
        if (!empty($this->getCardInfo()['loyaltyPoints'])) {
            return $this->getCardInfo()['loyaltyPoints'];
        }

        return null;
    }

    /**
     * @param array $data
     * @return array
     */
    public function setData(array $data): array
    {
        return $this->data = $data;
    }
}
