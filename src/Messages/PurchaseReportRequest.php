<?php
/**
 * PayU Purchase Report Request
 */

namespace Omnipay\PayU\Messages;

class PurchaseReportRequest extends AbstractRequest
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
            $startDate = $this->getStartDate();
            $endDate = $this->getEndDate();
            $timestamp = time();

            $hashArray = [
                'merchant' => $merchant,
                'startdate' => $startDate,
                'enddate' => $endDate,
                'timeStamp' => $timestamp
            ];

            $hashString = "";

            foreach ($hashArray as $key => $value) {
                $hashString .= strlen($value) . $value;
            }

            $hash = hash_hmac('md5', $hashString, $secret);


            /**
             * Payu hash hesplarken startdate ve enddate şeklinde küçük harf kullanırken,
             * data yollanmasında bunları camelCase yapmış
             */
            $data = [
                'merchant' => $merchant,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'timeStamp' => $timestamp,
                'signature' => $hash
            ];

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
        return $this->getApiUrl() . '/reports/orders';
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->getParameter('startDate');
    }

    /**
     * @param $value
     * @return PurchaseReportRequest
     */
    public function setStartDate($value): PurchaseReportRequest
    {
        return $this->setParameter('startDate', $value);
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->getParameter('endDate');
    }

    /**
     * @param $value
     * @return PurchaseReportRequest
     */
    public function setEndDate($value): PurchaseReportRequest
    {
        return $this->setParameter('endDate', $value);
    }

    /**
     * @param $data
     * @param $statusCode
     * @return PurchaseReportResponse
     */
    protected function createResponse($data, $statusCode): PurchaseReportResponse
    {
        $response = new PurchaseReportResponse($this, $data, $statusCode);
        $requestParams = $this->getRequestParams();
        $response->setServiceRequestParams($requestParams);

        return $response;
    }

    public function getSensitiveData(): array
    {
        return [];
    }
}
