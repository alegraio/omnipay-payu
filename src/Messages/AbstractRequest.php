<?php
/**
 * PayU Abstract Request
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\PayU\Mask;
use Omnipay\PayU\PayURequestInterface;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest implements PayURequestInterface
{
    public const DEFAULT_LANG = 'TR';

    /** @var string */
    public $apiUrl = 'https://secure.payu.com.tr';

    protected $requestParams;

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
     * @return mixed
     */
    public function getOrderRef()
    {
        return $this->getParameter('orderRef');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setOrderRef($value)
    {
        return $this->setParameter('orderRef', $value);
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
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|Response
     * @throws InvalidResponseException
     */
    public function sendData($data)
    {
        try {
            if ($this->getHttpMethod() === 'GET') {
                $requestUrl = $this->getEndpoint() . '?' . http_build_query($data);
                $body = null;
            } else {
                $body = http_build_query($data, '', '&');
                $requestUrl = $this->getEndpoint();
            }

            $httpRequest = $this->httpClient->request($this->getHttpMethod(), $requestUrl,
                ['Content-Type' => 'application/x-www-form-urlencoded'],
                $body);

            $response = (string)$httpRequest->getBody()->getContents();

            return $this->response = $this->createResponse($response, $httpRequest->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    protected function setRequestParams(array $data): void
    {
        array_walk_recursive($data, [$this, 'updateValue']);
        $this->requestParams = $data;
    }

    protected function updateValue(&$data, $key): void
    {
        $sensitiveData = $this->getSensitiveData();
        if (\in_array($key, $sensitiveData, true)) {
            $data = Mask::mask($data);
        }
    }

    /**
     * @return array
     */
    protected function getRequestParams(): array
    {
        return [
            'url' => $this->getEndPoint(),
            'data' => $this->requestParams,
            'method' => $this->getHttpMethod()
        ];
    }
}
