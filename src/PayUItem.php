<?php

namespace Omnipay\PayU;

use Omnipay\Common\Item;

class PayUItem extends Item implements PayUItemInterface
{
    public function getSku()
    {
        return $this->getParameter('sku');
    }

    public function setSku(string $value)
    {
        return $this->setParameter('sku', $value);
    }

    public function getPriceType()
    {
        return $this->getParameter('price_type') ?? 'with_vat';
    }

    public function setPriceType(string $value)
    {
        return $this->setParameter('price_type', $value);
    }

}