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
        $data = $this->getData();
        return (isset($data['ORDER_STATUS']) && $data['ORDER_STATUS'] !== 'NOT_FOUND');
    }
}
