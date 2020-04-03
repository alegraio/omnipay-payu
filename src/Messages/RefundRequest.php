<?php
/**
 * PayU Refund Request
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\Common\Message\ResponseInterface;

class RefundRequest extends AbstractRequest
{
    use ConstantTrait;

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function getData()
    {
        try {
            $irn = [
                "MERCHANT" => $this->getClientId(),
                "ORDER_REF" => $this->getOrderRef(),
                "ORDER_AMOUNT" => $this->formatCurrency($this->getOrderAmount()),
                "ORDER_CURRENCY" => $this->getCurrency() ?? static::$DEFAULT_CURRENCY,
                "IRN_DATE" => $this->getIrnDate(),
                'AMOUNT' => $this->getAmount()
            ];

            $hashString = "";
            foreach ($irn as $key => $value) {
                $hashString .= strlen($value) . $value;
            }
            $hash = hash_hmac('md5', $hashString, $this->getSecret());
            $irn['ORDER_HASH'] = $hash;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $irn;
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return parent::getApiUrl() . '/order/irn.php';
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
     * @return RefundRequest
     */
    public function setOrderRef($value)
    {
        return $this->setParameter('orderRef', $value);
    }

    /**
     * @return mixed
     */
    public function getOrderAmount()
    {
        return $this->getParameter('orderAmount');
    }

    /**
     * @param $value
     * @return RefundRequest
     */
    public function setOrderAmount($value)
    {
        return $this->setParameter('orderAmount', $value);
    }

    /**
     * @return mixed
     */
    public function getIrnDate()
    {
        return $this->getParameter('irnDate') ?? date('Y-m-d H:i:s');
    }

    /**
     * @param $value
     * @return RefundRequest
     */
    public function setIrnDate($value)
    {
        return $this->setParameter('irnDate', $value);
    }

    /**
     * @param mixed $data
     * @return ResponseInterface|RefundResponse|Response
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
     * @return RefundResponse
     */
    protected function createResponse($data, $statusCode): RefundResponse
    {
        return new RefundResponse($this, $data, $statusCode);
    }
}
