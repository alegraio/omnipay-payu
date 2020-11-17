<?php
/**
 * PayU Fetch Transaction Request
 */

namespace Omnipay\PayU\Messages;

class FetchTransactionRequest extends AbstractRequest
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
                "REFNOEXT" => $this->getRefNoExt(),
            ];

            $hashString = "";
            foreach ($data as $key => $value) {
                $hashString .= strlen($value) . $value;
            }

            $hash = hash_hmac('md5', $hashString, $this->getSecret());
            $data['HASH'] = $hash;
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
        return $this->getApiUrl() . '/order/ios.php';
    }

    /**
     * @return mixed
     */
    public function getRefNoExt()
    {
        return $this->getParameter('refNoExt');
    }

    /**
     * @param $value
     * @return FetchTransactionRequest
     */
    public function setRefNoExt($value)
    {
        return $this->setParameter('refNoExt', $value);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return FetchTransactionResponse
     */
    protected function createResponse($data, $statusCode): FetchTransactionResponse
    {
        $response = new FetchTransactionResponse($this, $data, $statusCode);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}
