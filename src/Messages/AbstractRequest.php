<?php
/**
 * PayU Abstract Request
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;


abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    const DEFAULT_LANG = 'TR';

    /** @var string */
    protected $apiUrl = 'https://secure.payu.com.tr';


    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->getParameter('clientId');
    }

    public function setItems($items)
    {
        return parent::setItems($items);
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setClientId(string $value)
    {
        return $this->setParameter('clientId', $value);
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->getParameter('secret');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setSecret(string $value)
    {
        return $this->setParameter('secret', $value);
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    protected function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param $data
     * @param int $options
     * @return false|mixed|string
     */
    public function toJSON($data, $options = 0)
    {
        if (version_compare(phpversion(), '5.4.0', '>=') === true) {
            return json_encode($data, $options | 64);
        }
        return str_replace('\\/', '/', json_encode($data, $options));
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|Response
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        try {
            $httpRequest = $this->httpClient->request('POST', $this->getEndpoint(),
                ['Content-Type' => 'application/x-www-form-urlencoded'],
                http_build_query($data, '', '&'));

            $body = $httpRequest->getBody()->getContents();
            $parsedXML = @simplexml_load_string($body);
            $content = json_decode(json_encode((array)$parsedXML), true);

            return $this->response = $this->createResponse($content, $httpRequest->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new Response($this, $data, $statusCode);
    }
}
