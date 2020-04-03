<?php

namespace Omnipay\PayU;

interface PayUItemInterface
{
    public function setSku($value);

    public function getSku();

    public function setPriceType($value);

    public function getPriceType();

}