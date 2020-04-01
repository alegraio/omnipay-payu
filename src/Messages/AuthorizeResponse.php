<?php
/**
 * PayPU Authorize Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\RedirectResponseInterface;


class AuthorizeResponse extends Response implements RedirectResponseInterface
{

    public function getTransactionReference()
    {
        if (!empty($this->data['REFNO'])) {
            return $this->data['REFNO'];
        }

        return null;
    }

    public function getMessage()
    {
        if (!empty($this->data['RETURN_MESSAGE'])) {
            return $this->data['RETURN_CODE'] . " : " . $this->data['RETURN_MESSAGE'];
        }

        return null;
    }
}
