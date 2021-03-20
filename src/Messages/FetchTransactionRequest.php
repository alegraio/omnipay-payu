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
    public function getData(): array
    {
        try {
            $secret = $this->getSecret();
            $merchant = $this->getClientId();
            $refNoExt = $this->getOrderRef();
            $data = [
                'MERCHANT' => $merchant,
                'REFNOEXT' => $refNoExt,
                'SECRET_KEY' => $secret
            ];

            $hash_string = strlen($merchant) . $merchant;
            $hash_string .= strlen($refNoExt) . $refNoExt;
            $hash = hash_hmac('md5', $hash_string, $secret);
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
