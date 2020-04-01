<?php

namespace Omnipay\PayU\Messages;

class Item extends \Omnipay\Common\Item
{

    public function setParameter($key, $value)
    {
        return parent::setParameter($key, $value);
    }

    public function getParameter($key)
    {
        return parent::getParameter($key);
    }

    public function getSku()
    {
        return $this->getParameter('sku');
    }

    public function getPriceType()
    {
        return $this->getParameter('price_type');
    }

}

