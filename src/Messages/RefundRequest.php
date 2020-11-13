<?php
/**
 * PayU Refund Request
 */

namespace Omnipay\PayU\Messages;

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
            $data = [
                "MERCHANT" => $this->getClientId(),
                "ORDER_REF" => $this->getOrderRef(),
                "ORDER_AMOUNT" => $this->formatCurrency($this->getOrderAmount()),
                "ORDER_CURRENCY" => $this->getCurrency() ?? static::$DEFAULT_CURRENCY,
                "IRN_DATE" => $this->getIrnDate(),
                'AMOUNT' => $this->getAmount()
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
    protected function getEndpoint(): string
    {
        return $this->getApiUrl() . '/order/irn.php';
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
        return $this->getParameter('irnDate') ?? gmdate('Y-m-d H:i:s');
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
     * @param $data
     * @param $statusCode
     * @return RefundResponse
     */
    protected function createResponse($data, $statusCode): RefundResponse
    {
        $response = new RefundResponse($this, $data, $statusCode);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}
