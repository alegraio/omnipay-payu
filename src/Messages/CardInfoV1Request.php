<?php
/**
 * PayU Card Info V1 Request
 */

namespace Omnipay\PayU\Messages;

class CardInfoV1Request extends AbstractRequest
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
                "timestamp" => $this->getTimestamp()
            ];

            $hashString = implode("", $data);
            $hash = hash_hmac('sha256', $hashString, $this->getSecret());
            $data['signature'] = $hash;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $data;
    }

    protected function getHttpMethod()
    {
        return 'GET';
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return parent::getApiUrl() . '/api/card-info/v1/' . $this->getBin();
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->getParameter('timestamp') ?? time();
    }

    /**
     * @param $value
     * @return CardInfoV1Request
     */
    public function setBin($value)
    {
        return $this->setParameter('bin', $value);
    }

    /**
     * @return mixed
     */
    public function getBin()
    {
        return $this->getParameter('bin');
    }

    /**
     * @param $value
     * @return CardInfoV1Request
     */
    public function setTimestamp($value)
    {
        return $this->setParameter('timestamp', $value);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return CardInfoV1Response
     */
    protected function createResponse($data, $statusCode): CardInfoV1Response
    {
        return new CardInfoV1Response($this, $data, $statusCode);
    }
}
