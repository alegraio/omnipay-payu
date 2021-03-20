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
        return true;
    }

    public function getTransactionReference(): ?string
    {
        return $this->getData()['REFNO'] ?? null;
    }

    public function getOrderReferenceNoExt()
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

    public function getMessage(): ?string
    {
        return $this->getData()['ORDER_STATUS'] ?? null;
    }
}
