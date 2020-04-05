<?php
/**
 * PayU Order Transaction Response
 */

namespace Omnipay\PayU\Messages;

class OrderTransactionResponse extends Response
{

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        if ($this->getCode() === 200) {
            return true;
        }

        return false;
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
