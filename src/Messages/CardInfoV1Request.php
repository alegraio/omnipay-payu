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
    public function getData(): array
    {
        try {
            $data = [
                "merchant" => $this->getClientId(),
                "timestamp" => $this->getTimestamp()
            ];

            $hashString = implode("", $data);
            $hash = hash_hmac('sha256', $hashString, $this->getSecret());
            $data['signature'] = $hash;
            $this->setRequestParams($data);
        } catch (\Exception $exception) {
            throw new \RuntimeException($exception->getMessage());
        }

        return $data;
    }

    protected function getHttpMethod(): string
    {
        return 'GET';
    }

    /**
     * @return string
     */
    public function getEndpoint(): string
    {
        return $this->getApiUrl() . '/api/card-info/v1/' . $this->getBin();
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
    public function setBin($value): CardInfoV1Request
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
    public function setTimestamp($value): CardInfoV1Request
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
        $response = new CardInfoV1Response($this, $data, $statusCode);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}
