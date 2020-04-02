<?php
/**
 * PayU Purchase Request
 */

namespace Omnipay\PayU\Messages;

class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        return parent::getData();
    }
}
