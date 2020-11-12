<?php
/**
 * PayU Card Info V1 Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\RequestInterface;

class CardInfoV1Response extends AbstractResponse
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

    public function getCode()
    {
        return $this->statusCode;
    }

    public function getMessage()
    {
        if (!empty($this->getData()['meta']) && !empty($this->getData()['meta']['status'])) {
            return $this->getData()['meta']['status']['message'];
        }

        return null;
    }

    /**
     * @return array
     */
    public function getCardInfo()
    {
        if (!empty($this->getData()['cardBinInfo'])) {
            return $this->getData()['cardBinInfo'];
        }

        return [];
    }

    /**
     * @return mixed|null
     */
    public function getCardBinType()
    {
        if (!empty($this->getCardInfo()['binType'])) {
            return $this->getCardInfo()['binType'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardBinIssuer()
    {
        if (!empty($this->getCardInfo()['binIssuer'])) {
            return $this->getCardInfo()['binIssuer'];
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
        if (!empty($this->getCardInfo()['country'])) {
            return $this->getCardInfo()['country'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardProgram()
    {
        if (!empty($this->getCardInfo()['program'])) {
            return $this->getCardInfo()['program'];
        }

        return null;
    }

    /**
     * @return mixed|mixed
     */
    public function getCardInstallments()
    {
        if (!empty($this->getCardInfo()['installments'])) {
            return $this->getCardInfo()['installments'];
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function getCardPaymentMethod()
    {
        if (!empty($this->getCardInfo()['paymentMethod'])) {
            return $this->getCardInfo()['paymentMethod'];
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
