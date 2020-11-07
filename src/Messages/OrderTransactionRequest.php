<?php
/**
 * PayU Order Transaction Request
 */

namespace Omnipay\PayU\Messages;

class OrderTransactionRequest extends AbstractRequest
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
     * @return OrderTransactionRequest
     */
    public function setRefNoExt($value)
    {
        return $this->setParameter('refNoExt', $value);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return OrderTransactionResponse
     */
    protected function createResponse($data, $statusCode): OrderTransactionResponse
    {
        return new OrderTransactionResponse($this, $data, $statusCode);
    }
}
