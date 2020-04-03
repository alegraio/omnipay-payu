<?php
/*
 * PayU Complete Purchase Request
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseRequest extends AbstractRequest
{
    use ConstantTrait;

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function getData()
    {
        try {
            $data = [
                "MERCHANT" => $this->getClientId(),
                "ORDER_REF" => $this->getOrderRef(),
                "ORDER_AMOUNT" => $this->getAmount(),
                "ORDER_CURRENCY" => $this->getCurrency() ?? static::$DEFAULT_CURRENCY,
                "IDN_DATE" => $this->getIdnDate()
            ];

            $hashString = "";
            foreach ($data as $key => $value) {
                $hashString .= strlen($value) . $value;
            }
            $hash = hash_hmac('md5', $hashString, $this->getSecret());
            $data['ORDER_HASH'] = $hash;

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $data;
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return parent::getApiUrl() . '/order/idn.php';
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
     * @return CompletePurchaseRequest
     */
    public function setOrderRef($value)
    {
        return $this->setParameter('orderRef', $value);
    }

    /**
     * @return mixed
     */
    public function getIdnDate()
    {
        return $this->getParameter('idnDate') ?? date('Y-m-d H:i:s');
    }

    /**
     * @param $value
     * @return CompletePurchaseRequest
     */
    public function setIdnDate($value)
    {
        return $this->setParameter('idnDate', $value);
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|CompletePurchaseResponse|Response
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
            $content = explode("|", current($content));

            return $this->response = $this->createResponse($content, $httpRequest->getStatusCode());
        } catch (\Exception $e) {
            throw new InvalidResponseException(
                'Error communicating with payment gateway: ' . $e->getMessage(),
                $e->getCode()
            );
        }
    }

    /**
     * @param $data
     * @param $statusCode
     * @return CompletePurchaseResponse
     */
    protected function createResponse($data, $statusCode): CompletePurchaseResponse
    {
        return new CompletePurchaseResponse($this, $data, $statusCode);
    }
}
