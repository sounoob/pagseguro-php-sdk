<?php

namespace Sounoob\pagseguro;

use Sounoob\pagseguro\config\Config;
use Sounoob\pagseguro\config\Url;
use Sounoob\pagseguro\core\PagSeguro;
use Sounoob\pagseguro\core\Utils;

/**
 * Class Payment
 * @package Sounoob\pagseguro
 */
class Payment extends PagSeguro
{
    /**
     * @var array
     */
    private $item = array();
    /**
     * @var string
     */
    public $redirecURL = '';

    /**
     * Payment constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->post['currency'] = 'BRL';
        $this->post['shippingAddressRequired'] = 'true';
        $this->post['receiverEmail'] = Config::getEmail();
        $this->post['reference'] = 'generated automatically in: ' . date('r');
    }

    /**
     * @param array $itens
     */
    public function addItens(array $itens)
    {
        foreach ($itens as $row) {
            $row['amount'] = isset($row['amount']) ? $row['amount'] : 0;
            $row['weight'] = isset($row['weight']) ? $row['weight'] : null;
            $row['shippingCost'] = isset($row['shippingCost']) ? $row['shippingCost'] : null;
            $this->addItem($row['id'], $row['description'], $row['quantity'], $row['amount'], $row['weight'], $row['shippingCost']);
        }
    }

    /**
     * @param string $id
     * @param string $description
     * @param int $quantity
     * @param double $amount
     * @param int $weight
     * @param double $shippingCost
     */
    public function addItem($id, $description, $quantity, $amount, $weight = 0, $shippingCost = null)
    {
        $this->item[] = array(
            'id' => $id,
            'amount' => $amount,
            'description' => $description,
            'quantity' => $quantity,
            'weight' => $weight,
            'shippingCost' => $shippingCost,
        );
    }

    /**
     * @param double $extraAmount
     */
    public function setExtraAmount($extraAmount)
    {
        $this->post['extraAmount'] = $extraAmount;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->post['reference'] = $reference;
    }

    /**
     * @param string $url
     */
    public function setRedirectUrl($url)
    {
        $this->post['redirectURL'] = $url;
    }

    /**
     * @param string $name
     */
    public function setSenderName($name)
    {
        $this->post['senderName'] = $name;
    }

    /**
     * @param int $cpf
     */
    public function setSenderCPF($cpf)
    {
        $cpf = Utils::onlyNumbers($cpf, 11);
        $this->post['senderCPF'] = $cpf;
    }

    /**
     * @param int $areaCode
     * @param int $phone
     */
    public function setSenderPhone($areaCode, $phone)
    {
        $areaCode = Utils::onlyNumbers($areaCode);
        $areaCode = substr($areaCode, 0, 2);

        $phone = Utils::onlyNumbers($phone);
        $phone = substr($phone, 0, 9);

        $this->post['senderAreaCode'] = $areaCode;
        $this->post['senderPhone'] = $phone;
    }

    /**
     * @param string $email
     */
    public function setSenderEmail($email)
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        $this->post['senderEmail'] = $email;
    }
    public function setShippingTypePAC()
    {
        $this->setShippingType(1);
    }
    public function setShippingTypeSedex()
    {
        $this->setShippingType(2);
    }
    public function setShippingTypeOther()
    {
        $this->setShippingType(3);
    }


    /**
     * @param int $shippingType
     */
    private function setShippingType($shippingType)
    {
        $this->post['shippingType'] = $shippingType;
    }

    /**
     * @param string $street
     * @deprecated
     */
    public function setShippingAddressStreet($street)
    {
        $this->post['shippingAddressStreet'] = $street;
    }

    /**
     * @param string $number
     * @deprecated
     */
    public function setShippingAddressNumber($number)
    {
        $this->post['shippingAddressNumber'] = $number;
    }

    /**
     * @param string $complement
     * @deprecated
     */
    public function setShippingAddressComplement($complement)
    {
        $this->post['shippingAddressComplement'] = $complement;
    }

    /**
     * @param string $address
     * @param string $number
     * @param string $complement
     */
    public function setShippingAddress($address, $number = 's/n', $complement = '')
    {
        $this->post['shippingAddressStreet'] = $address;
        $this->post['shippingAddressNumber'] = $number;
        $this->post['shippingAddressComplement'] = $complement;

    }

    /**
     * @param string $district
     */
    public function setShippingAddressDistrict($district)
    {
        $this->post['shippingAddressDistrict'] = $district;
    }

    /**
     * @param int $postalCode
     */
    public function setShippingAddressPostalCode($postalCode)
    {
        $postalCode = Utils::onlyNumbers($postalCode);
        $this->post['shippingAddressPostalCode'] = $postalCode;
    }

    /**
     * @param string $city
     */
    public function setShippingAddressCity($city)
    {
        $this->post['shippingAddressCity'] = $city;
    }

    /**
     * @param string $state
     */
    public function setShippingAddressState($state)
    {
        $state = strtoupper($state);
        if (strlen($state) === 2) {
            $this->post['shippingAddressState'] = $state;
        }
    }


    /**
     * @param string $country
     */
    public function setShippingAddressCountry($country)
    {
        $this->post['shippingAddressCountry'] = $country;
    }

    /**
     * @param bool $skip
     */
    public function skipAddress($skip = true)
    {
        $this->post['shippingAddressRequired'] = $skip === true ? 'false' : 'true';
    }

    /**
     *
     */
    private function buildItem()
    {
        $count = 1;
        foreach ($this->item as $item) {
            $this->post['itemId' . $count] = $item['id'];
            $this->post['itemDescription' . $count] = $item['description'];
            $this->post['itemAmount' . $count] = $item['amount'];
            $this->post['itemQuantity' . $count] = $item['quantity'];
            if ($item['weight']) {
                $this->post['itemWeight' . $count] = $item['weight'];
            }
            if ($item['shippingCost']) {
                $this->post['itemShippingCost' . $count] = $item['shippingCost'];
            }
            $count++;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function build()
    {
        foreach ($this->post as $key => $row) {
            if ($this->post['shippingAddressRequired'] === true
                && strpos($key, 'shipping') !== false
                && $key != 'shippingAddressRequired') {
                //PagSeguro error code 11057
                throw new \Exception('sender address not required with address data filled: ' . $key);
            }
        }
        $this->buildItem();
        parent::build();

        return $this->post;
    }

    /**
     * @return \SimpleXMLElement|\stdClass|void
     * @throws \Exception
     */
    public function send()
    {
        $this->url = 'v2/checkout';
        parent::send();

        $this->redirecURL = Url::getPage() . 'v2/checkout/payment.html?code=' . $this->result->code;
    }

    /**
     * @deprecated deprecated
     */
    public function checkoutCode()
    {
        $data = $this->send();
        return isset($data->code) ? $data->code : false;
    }

    /**
     * @deprecated deprecated
     */
    public function redirectCode()
    {
        if (!$this->result) {
            $this->send();
        }
        return $this->redirecURL;
    }
}
