<?php
/**
 * PayU Card Info V2 Request
 */

namespace Omnipay\PayU\Messages;

class CardInfoV2Request extends AbstractRequest
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
                "merchant" => $this->getClientId(),
                "dateTime" => $this->getDateTime(),
                "extraInfo" => true,
                "cc_cvv" => $this->getCvv(),
                "cc_owner" => $this->getOwner(),
                "exp_year" => $this->getExpYear(),
                "exp_month" => $this->getExpMonth(),
                "cc_number" => $this->getNumber()
            ];

            ksort($data);
            $hashString = "";
            foreach ($data as $key => $value) {
                $hashString .= strlen($value) . $value;
            }

            $hash = hash_hmac('sha256', $hashString, $this->getSecret());
            $data['signature'] = $hash;
            $this->setRequestParams($data);
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        return $data;
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getApiUrl() . '/api/card-info/v2/';
    }

    /**
     * @return mixed
     */
    public function getDateTime()
    {
        return $this->getParameter('dateTime') ?? gmdate("c", time());
    }

    /**
     * @param $value
     * @return CardInfoV2Request
     */
    public function setDateTime($value)
    {
        return $this->setParameter('dateTime', $value);
    }

    /**
     * @return mixed
     */
    public function getCvv()
    {
        return $this->getParameter('cvv');
    }

    /**
     * @param $value
     * @return CardInfoV2Request
     */
    public function setCvv($value)
    {
        return $this->setParameter('cvv', $value);
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->getParameter('owner');
    }

    /**
     * @param $value
     * @return CardInfoV2Request
     */
    public function setOwner($value)
    {
        return $this->setParameter('owner', $value);
    }

    /**
     * @return mixed
     */
    public function getExpYear()
    {
        return $this->getParameter('expYear');
    }

    /**
     * @param $value
     * @return CardInfoV2Request
     */
    public function setExpYear($value)
    {
        return $this->setParameter('expYear', $value);
    }

    /**
     * @return mixed
     */
    public function getExpMonth()
    {
        return $this->getParameter('expMonth');
    }

    /**
     * @param $value
     * @return CardInfoV2Request
     */
    public function setExpMonth($value)
    {
        return $this->setParameter('expMonth', $value);
    }

    /**
     * @param $value
     * @return CardInfoV2Request
     */
    public function setNumber($value)
    {
        return $this->setParameter('number', $value);
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->getParameter('number');
    }

    /**
     * @param $data
     * @param $statusCode
     * @return CardInfoV2Response
     */
    protected function createResponse($data, $statusCode): CardInfoV2Response
    {
        $response = new CardInfoV2Response($this, $data, $statusCode);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return ['cc_cvv', 'cc_owner', 'exp_year', 'exp_month', 'cc_number'];
    }
}
