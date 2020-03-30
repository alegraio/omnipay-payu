<?php
/**
 * PayU Purchase Request
 */

namespace Omnipay\PayU\Messages;


class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();
        return $data;
    }
}
