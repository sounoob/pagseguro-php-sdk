<?php

include_once "core/Utils.php";
include_once "core/PagSeguro.php";

class Payment extends PagSeguro
{
    private $item = array();
    public $redirecURL = null;

    public function __construct()
    {
        parent::__construct();

        $this->post['currency'] = 'BRL';
        $this->post['shippingAddressRequired'] = 'true';
        $this->post['receiverEmail'] = Config::getEmail();
        $this->post['reference'] = 'generated automatically in: ' . date('r');
    }

    public function addItens(array $itens)
    {
        foreach ($itens as $row) {
            $row['amount'] = isset($row['amount']) ? $row['amount'] : 0;
            $row['weight'] = isset($row['weight']) ? $row['weight'] : null;
            $row['shippingCost'] = isset($row['shippingCost']) ? $row['shippingCost'] : null;
            $this->addItem($row['id'], $row['description'], $row['quantity'], $row['amount'], $row['weight'], $row['shippingCost']);
        }
    }

    public function addItem($id = null, $description = "", $quantity = 0, $amount = 0, $weight = null, $shippingCost = null)
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

    public function setExtraAmount($extraAmount)
    {
        $this->post['extraAmount'] = $extraAmount;
    }

    public function setReference($reference)
    {
        $this->post['reference'] = $reference;
    }

    public function setRedirectUrl($url)
    {
        $this->post['redirectURL'] = $url;
    }

    public function setSenderName($senderName)
    {
        $this->post['senderName'] = $senderName;
    }

    public function setSenderCPF($senderCPF)
    {
        $senderCPF = Utils::onlyNumbers($senderCPF);
        $senderCPF = substr($senderCPF, 0, 11);
        $this->post['senderCPF'] = $senderCPF;
    }

    public function setSenderPhone($senderAreaCode, $senderPhone)
    {
        $senderAreaCode = Utils::onlyNumbers($senderAreaCode);
        $senderAreaCode = substr($senderAreaCode, 0, 2);

        $senderPhone = Utils::onlyNumbers($senderPhone);
        $senderPhone = substr($senderPhone, 0, 9);

        $this->post['senderAreaCode'] = $senderAreaCode;
        $this->post['senderPhone'] = $senderPhone;
    }

    public function setSenderEmail($senderEmail)
    {
        $senderEmail = filter_var($senderEmail, FILTER_VALIDATE_EMAIL);
        $this->post['senderEmail'] = $senderEmail;
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


    private function setShippingType($shippingType)
    {
        $this->post['shippingType'] = $shippingType;
    }

    public function setShippingAddressStreet($shippingAddressStreet)
    {
        $this->post['shippingAddressStreet'] = $shippingAddressStreet;
    }

    public function setShippingAddressNumber($shippingAddressNumber)
    {
        $this->post['shippingAddressNumber'] = $shippingAddressNumber;
    }

    public function setShippingAddressComplement($shippingAddressComplement)
    {
        $this->post['shippingAddressComplement'] = $shippingAddressComplement;
    }

    public function setShippingAddressDistrict($shippingAddressDistrict)
    {
        $this->post['shippingAddressDistrict'] = $shippingAddressDistrict;
    }

    public function setShippingAddressPostalCode($shippingAddressPostalCode)
    {
        $shippingAddressPostalCode = Utils::onlyNumbers($shippingAddressPostalCode);
        $this->post['shippingAddressPostalCode'] = $shippingAddressPostalCode;
    }

    public function setShippingAddressCity($shippingAddressCity)
    {
        $this->post['shippingAddressCity'] = $shippingAddressCity;
    }

    public function setShippingAddressState($shippingAddressState)
    {
        $shippingAddressState = strtoupper($shippingAddressState);
        if (strlen($shippingAddressState) === 2) {
            $this->post['shippingAddressState'] = $shippingAddressState;
        }
    }


    public function setShippingAddressCountry($shippingAddressCountry)
    {
        $this->post['shippingAddressCountry'] = $shippingAddressCountry;
    }

    public function skipAddress($skip = true)
    {
        $this->post['shippingAddressRequired'] = $skip === true ? 'false' : 'true';
    }

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

    public function build()
    {
        foreach ($this->post as $key => $row) {
            if($this->post['shippingAddressRequired'] === true
                && strpos($key, 'shipping') !== false
                && $key != 'shippingAddressRequired') {
                //PagSeguro error code 11057
                throw new Exception('sender address not required with address data filled: ' . $key);
            }
        }
        $this->buildItem();
        parent::build();

        return $this->post;
    }

    public function send()
    {
        $this->url = 'v2/checkout';
        parent::send();

        $this->redirecURL = URL::getPage() . 'v2/checkout/payment.html?code=' . $this->result->code;
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
        if(!$this->result) {
            $this->send();
        }
        return $this->redirecURL;
    }
}
