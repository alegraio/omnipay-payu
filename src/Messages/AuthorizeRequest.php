<?php
/**
 * PayU Authorize Request
 */

namespace Omnipay\PayU\Messages;

use Omnipay\Common\ItemBag;
use Omnipay\PayU\PayUItem;
use Omnipay\PayU\PayUItemBag;

class AuthorizeRequest extends AbstractRequest
{
    use ConstantTrait;

    /**
     * Set the items in this order
     *
     * @param array $items An array of items in this order
     * @return AuthorizeRequest
     */
    public function setItems($items)
    {
        $itemBag = $items;
        if ($items && !$items instanceof ItemBag) {
            $itemBag = new PayUItemBag($items);
        }

        return $this->setParameter('items', $itemBag);
    }

    public function getData()
    {
        $data = [
            "MERCHANT" => $this->getClientId(),
            "LANGUAGE" => $this->getLang(),
            "ORDER_REF" => $this->getOrderRef(),
            "ORDER_DATE" => gmdate('Y-m-d H:i:s'),
            "PAY_METHOD" => $this->getPaymentMethods($this->getPaymentMethod()),
            "PRICES_CURRENCY" => $this->getCurrency() ?? static::$DEFAULT_CURRENCY,
            "CC_NUMBER" => $this->getCard()->getNumber() ?? '',
            "EXP_MONTH" => $this->getCard()->getExpiryMonth(),
            "EXP_YEAR" => $this->getCard()->getExpiryYear(),
            "CC_CVV" => $this->getCard()->getCvv(),
            "CC_OWNER" => $this->getCard()->getName() ?? '',
            "BILL_FNAME" => $this->getCard()->getBillingFirstName() ?? '',
            "BILL_LNAME" => $this->getCard()->getBillingLastName() ?? '',
            "BILL_EMAIL" => $this->getCard()->getEmail() ?? '',
            "BILL_PHONE" => $this->getCard()->getBillingPhone() ?? '',
            "BILL_FAX" => $this->getCard()->getBillingFax() ?? '',
            "BILL_ADDRESS" => $this->getCard()->getBillingAddress1() ?? '',
            "BILL_ADDRESS2" => $this->getCard()->getBillingAddress2() ?? '',
            "BILL_ZIPCODE" => $this->getCard()->getBillingPostcode() ?? '',
            "BILL_CITY" => $this->getCard()->getBillingCity() ?? '',
            "BILL_COUNTRYCODE" => $this->getCard()->getBillingCountry() ?? '',
            "BILL_STATE" => $this->getCard()->getBillingState() ?? '',
            "DELIVERY_FNAME" => $this->getCard()->getShippingFirstName() ?? '',
            "DELIVERY_LNAME" => $this->getCard()->getShippingLastName() ?? '',
            "DELIVERY_EMAIL" => $this->getCard()->getEmail() ?? '',
            "DELIVERY_PHONE" => $this->getCard()->getShippingPhone() ?? '',
            "DELIVERY_COMPANY" => $this->getCard()->getShippingCompany() ?? '',
            "DELIVERY_ADDRESS" => $this->getCard()->getShippingAddress1() ?? '',
            "DELIVERY_ADDRESS2" => $this->getCard()->getShippingAddress2() ?? '',
            "DELIVERY_ZIPCODE" => $this->getCard()->getShippingPostcode() ?? '',
            "DELIVERY_CITY" => $this->getCard()->getShippingCity() ?? '',
            "DELIVERY_STATE" => $this->getCard()->getShippingCity() ?? '',
            "DELIVERY_COUNTRYCODE" => $this->getCard()->getShippingState() ?? '',
            "BACK_REF" => $this->getReturnUrl() ?? '',
        ];

        $data['SELECTED_INSTALLMENTS_NUMBER'] = !empty($this->getInstallmentNumber()) ? $this->getInstallmentNumber() : "1";

        $items = $this->getItems();
        /** @var PayUItem $item */
        foreach ($items as $item) {
            $data['ORDER_PNAME'][] = $item->getName();
            $data['ORDER_PCODE'][] = $item->getSku();
            $data['ORDER_PINFO'][] = $item->getDescription() ?? '';
            $data['ORDER_PRICE'][] = $this->formatCurrency($item->getPrice());
            $data['ORDER_QTY'][] = $item->getQuantity();
            $data['ORDER_VAT'][] = $item->getVat();
            $data['ORDER_PRICE_TYPE'][] = $this->getPriceTypes($item->getPriceType());
        }

        ksort($data);

        $hashString = '';
        array_walk_recursive($data, static function ($val) use (&$hashString) {
            $hashString .= mb_strlen($val) . $val;
            return $hashString;
        });

        $data["ORDER_HASH"] = hash_hmac("md5", $hashString, $this->getSecret());

        return $data;
    }

    /**
     * Get transaction description.
     *
     * The REST API does not currently have support for passing an invoice number
     * or transaction ID.
     *
     * @return string
     */
    public function getDescription(): string
    {
        $id = $this->getTransactionId();
        $desc = parent::getDescription();

        if (empty($id)) {
            return $desc;
        }

        if (empty($desc)) {
            return $id;
        }

        return "$id : $desc";
    }

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return $this->getApiUrl() . '/order/alu/v3';
    }

    /**
     * @param $data
     * @param $statusCode
     * @return AuthorizeResponse
     */
    protected function createResponse($data, $statusCode): AuthorizeResponse
    {
        return new AuthorizeResponse($this, $data, $statusCode);
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->getParameter('lang') ?: self::DEFAULT_LANG;
    }

    /**
     * @param string $value
     * @return AuthorizeRequest
     */
    public function setLang(string $value)
    {
        return $this->setParameter('lang', $value);
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
     * @return AuthorizeRequest
     */
    public function setOrderDate($value)
    {
        return $this->setParameter('orderDate', $value);
    }

    /**
     * @return mixed
     */
    public function getOrderDate()
    {
        return $this->getParameter('orderDate');
    }

    /**
     * @param $value
     * @return AuthorizeRequest
     */
    public function setOrderRef($value)
    {
        return $this->setParameter('orderRef', $value);
    }

    /**
     * @return mixed
     */
    public function getInstallmentNumber()
    {
        return $this->getParameter('installmentNumber');
    }

    /**
     * @param int $value
     * @return AuthorizeRequest
     */
    public function setInstallmentNumber(int $value)
    {
        return $this->setParameter('installmentNumber', $value);
    }
}

