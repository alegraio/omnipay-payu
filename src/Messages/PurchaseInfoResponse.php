<?php
/**
 * PayU Refund Response
 */

namespace Omnipay\PayU\Messages;

class PurchaseInfoResponse extends Response
{
    public function isSuccessful(): bool
    {
        $data = $this->getData();
        return (isset($data['ORDER_STATUS']) && $data['ORDER_STATUS'] !== 'NOT_FOUND');
    }
}
