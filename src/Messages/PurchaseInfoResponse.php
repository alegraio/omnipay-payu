<?php
/**
 * PayU Refund Response
 */

namespace Omnipay\PayU\Messages;

class PurchaseInfoResponse extends Response
{
    protected $statusCode;

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return isset($this->getData()['ORDER_STATUS']);
    }
}
