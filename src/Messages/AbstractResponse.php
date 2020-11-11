<?php
/**
 * PayU Abstract Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\RedirectResponseInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse implements RedirectResponseInterface
{
    /** @var array */
    public $serviceRequestParams;

    /**
     * @return array
     */
    public function getServiceRequestParams(): array
    {
        return $this->serviceRequestParams;
    }

    /**
     * @param array $serviceRequestParams
     */
    public function setServiceRequestParams(array $serviceRequestParams): void
    {
        $this->serviceRequestParams = $serviceRequestParams;
    }

}