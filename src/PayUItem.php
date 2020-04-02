<?php

namespace Omnipay\PayU;

use Omnipay\Common\Item;

class PayUItem extends Item implements PayUItemInterface
{
    public function getSku()
    {
        return $this->getParameter('sku');
    }

    public function getPriceType()
    {
        return $this->getParameter('price_type') ?? 'with_vat';
    }

}