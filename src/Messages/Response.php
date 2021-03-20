<?php
/**
 * PayU  Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\RequestInterface;

class Response extends AbstractResponse
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
    public function isSuccessful(): bool
    {
        return !('SUCCESS' !== $this->data['STATUS']);
    }

    public function getCode()
    {
        if (!empty($this->data['RETURN_CODE'])) {
            return $this->data['RETURN_CODE'];
        }

        return $this->statusCode;
    }

    public function getTransactionReference(): ?string
    {
        if (!empty($this->data['REFNO'])) {
            return $this->data['REFNO'];
        }

        return null;
    }

    public function getMessage(): ?string
    {
        if (!empty($this->data['RETURN_MESSAGE'])) {
            return $this->data['RETURN_MESSAGE'];
        }

        return null;
    }

    /**
     * @return bool
     */
    public function isRedirect(): bool
    {
        return !empty($this->data['RETURN_CODE']) && $this->isSuccessful() && $this->data['RETURN_CODE'] === '3DS_ENROLLED';
    }

    /**
     * @return string|null
     */
    public function getRedirectUrl(): ?string
    {
        if (!empty($this->data['RETURN_CODE']) && $this->data['RETURN_CODE'] === '3DS_ENROLLED') {
            return $this->data['URL_3DS'];
        }

        return null;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}