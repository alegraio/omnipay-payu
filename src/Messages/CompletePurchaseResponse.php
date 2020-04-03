<?php
/**
 * PayU Complete Purchase Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\RedirectResponseInterface;

class CompletePurchaseResponse extends Response implements RedirectResponseInterface
{
    const SUCCESS_CODES = [1, 7];

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {

        if (isset($this->data[1]) && (in_array($this->data[1], self::SUCCESS_CODES))) {
            return true;
        }

        return false;
    }

    public function getTransactionReference()
    {
        return $this->data[0] ?? null;
    }

    public function getMessage()
    {

        if (isset($this->data[1]) && isset($this->data[2])) {
            return $this->data[1] . " : " . $this->data[2];
        }

        return null;
    }
}
