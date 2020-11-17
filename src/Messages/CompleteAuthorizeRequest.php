<?php
/*
 * PayU Complete Authorize Request
 */

namespace Omnipay\PayU\Messages;

class CompleteAuthorizeRequest extends AbstractRequest
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

            $this->setRequestParams($data);

        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        return $data;
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getApiUrl() . '/order/idn.php';
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
     * @return CompleteAuthorizeRequest
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
        return $this->getParameter('idnDate') ?? gmdate('Y-m-d H:i:s');
    }

    /**
     * @param $value
     * @return CompleteAuthorizeRequest
     */
    public function setIdnDate($value)
    {
        return $this->setParameter('idnDate', $value);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return CompleteAuthorizeResponse
     */
    protected function createResponse($data, $statusCode): CompleteAuthorizeResponse
    {
        $response = new CompleteAuthorizeResponse($this, $data, $statusCode);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}
