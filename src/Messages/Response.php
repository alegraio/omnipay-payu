<?php
/**
 * PayU  Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;


class Response extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {

        if ('SUCCESS' !== $this->data['STATUS']) {
            return false;
        }

        return true;
    }

    public function getCode()
    {
        return $this->statusCode;
    }

}
