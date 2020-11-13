<?php

namespace Omnipay\PayU;

interface PayURequestInterface
{
    public function getSensitiveData(): array;
}