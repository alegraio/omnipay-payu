<?php

namespace Omnipay\PayU;

use Omnipay\Common\Item;

class PayUItem extends Item implements PayUItemInterface
{
    /**
     * Set the sku
     * @param $value
     * @return PayUItem
     */
    public function setSku($value)
    {
        return $this->setParameter('sku', $value);
    }

    public function getSku()
    {
        return $this->getParameter('sku');
    }

    /**
     * Set the price type
     * @param $value
     * @return PayUItem
     */
    public function setPriceType($value)
    {
        return $this->setParameter('price_type', $value);
    }

    public function getPriceType()
    {
        return $this->getParameter('price_type') ?? 'with_vat';
    }

}