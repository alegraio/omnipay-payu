<?php
/**
 * PayU  Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse implements RedirectResponseInterface
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
        $parsedXML = @simplexml_load_string($this->getData());
        $content = json_decode(json_encode((array)$parsedXML), true);
        $this->setData($content);
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

    /**
     * @return bool
     */
    public function isRedirect()
    {
        if (!empty($this->data['RETURN_CODE']) && $this->data['RETURN_CODE'] === '3DS_ENROLLED') {
            return true;
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl()
    {
        if (!empty($this->data['RETURN_CODE']) && $this->data['RETURN_CODE'] === '3DS_ENROLLED') {
            return $this->data['URL_3DS'];
        }

        return null;
    }

    /**
     * @param array $data
     * @return array
     */
    public function setData(array $data): array
    {
        return $this->data = $data;
    }

}
