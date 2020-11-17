<?php
/**
 * PayU Order Transaction Response
 */

namespace Omnipay\PayU\Messages;

class FetchTransactionResponse extends Response
{

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->getCode() === 200;
    }

    public function getTransactionReference()
    {
        return $this->getData()['REFNO'] ?? null;
    }

    public function getOderReferenceNoExt()
    {
        return $this->getData()['REFNOEXT'] ?? null;
    }

    public function getOrderStatus()
    {
        return $this->getData()['ORDER_STATUS'] ?? null;
    }

    public function getPaymentMethod()
    {
        return $this->getData()['PAYMETHOD'] ?? null;
    }
}
