<?php
/**
 * PayU Refund Response
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\RequestInterface;

class PurchaseReportResponse extends AbstractResponse
{
    protected $statusCode;

    public function __construct(RequestInterface $request, $data, $statusCode = 200)
    {
        parent::__construct($request, $data);
        $this->statusCode = $statusCode;
        $content = json_decode($data, true);
        $this->setData($content ?? []);
    }

    public function isSuccessful(): bool
    {
        $data = $this->getData();
        return (isset($data['statusCode']) && $data['statusCode'] === '0');
    }

    public function getCode()
    {
        if (!empty($this->data['statusCode'])) {
            return $this->data['statusCode'];
        }

        return $this->statusCode;
    }

    public function getMessage(): ?string
    {
        return $this->data['statusDescription'] ?? null;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
