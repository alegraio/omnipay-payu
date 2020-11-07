<?php
/**
 * PayU Complete Authorize Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;
use Omnipay\Common\Message\RequestInterface;

class CompleteAuthorizeResponse extends AbstractResponse implements RedirectResponseInterface
{
    public const SUCCESS_CODES = [1, 7];
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
        $parsedXML = @simplexml_load_string($this->getData());
        $content = json_decode(json_encode((array)$parsedXML), true);
        $data = explode('|', current($content));
        $this->setData($data);
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return isset($this->data[1]) && (in_array($this->data[1], self::SUCCESS_CODES, false));
    }

    public function getTransactionReference()
    {
        return $this->data[0] ?? null;
    }

    public function getMessage()
    {
        if (isset($this->data[1], $this->data[2])) {
            return $this->data[1] . " : " . $this->data[2];
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
