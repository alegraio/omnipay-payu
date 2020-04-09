<?php

namespace Omnipay\PayU\Messages;

trait ConstantTrait
{

    static $DEFAULT_CURRENCY = 'TRY';

    /**
     * @param string $method
     * @return string
     */
    public function getPaymentMethods(string $method): string
    {
        $list = [
            'credit_card' => 'CCVISAMC',
            'bkm' => 'BKM',
            'cheap_money_transfer' => 'UPT',
            'online_transfer' => 'COMPAY',
            'transfer_eft' => 'WIRE'
        ];

        return isset($list[$method]) ? $list[$method] : null;

    }

    /**
     * @param string $type
     * @return string
     */
    public function getPriceTypes(string $type): string
    {
        $list = [
            'with_vat' => 'GROSS',
            'without_vat' => 'NET'
        ];

        return isset($list[$type]) ? $list[$type] : null;

    }
}