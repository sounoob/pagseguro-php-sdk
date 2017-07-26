<?php

include_once "Config.php";
include_once "Utils.php";
include_once "Curl.php";

class Payment extends Utils
{
    private $data = array();
    private $item = array();

    public function __construct()
    {
        $this->data['currency'] = 'BRL';
        $this->data['receiverEmail'] = Conf::getEmail();
        $this->data['reference'] = 'generated automatically in: ' . date('r');
    }

    public function additens($itens)
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
        $this->data['extraAmount'] = $extraAmount;
    }

    public function setReference($reference)
    {
        $this->data['reference'] = $reference;
    }

    public function setRedirectUrl($url)
    {
        $this->data['redirectURL'] = $url;
    }

    public function setSenderName($senderName)
    {
        $this->data['senderName'] = $senderName;
    }

    public function setSenderCPF($senderCPF)
    {
        $senderCPF = $this->only_numbers($senderCPF);
        $senderCPF = substr($senderCPF, 0, 11);
        $this->data['senderCPF'] = $senderCPF;
    }

    public function setSenderPhone($senderAreaCode, $senderPhone)
    {
        $senderAreaCode = $this->only_numbers($senderAreaCode);
        $senderAreaCode = substr($senderAreaCode, 0, 2);

        $senderPhone = $this->only_numbers($senderPhone);
        $senderPhone = substr($senderPhone, 0, 9);

        $this->data['senderAreaCode'] = $senderAreaCode;
        $this->data['senderPhone'] = $senderPhone;
    }

    public function setSenderEmail($senderEmail)
    {
        $senderEmail = filter_var($senderEmail, FILTER_VALIDATE_EMAIL);
        $this->data['senderEmail'] = $senderEmail;
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
        $this->data['shippingType'] = $shippingType;
    }

    public function setShippingAddressStreet($shippingAddressStreet)
    {
        $this->data['shippingAddressStreet'] = $shippingAddressStreet;
    }

    public function setShippingAddressNumber($shippingAddressNumber)
    {
        $this->data['shippingAddressNumber'] = $shippingAddressNumber;
    }

    public function setShippingAddressComplement($shippingAddressComplement)
    {
        $this->data['shippingAddressComplement'] = $shippingAddressComplement;
    }

    public function setShippingAddressDistrict($shippingAddressDistrict)
    {
        $this->data['shippingAddressDistrict'] = $shippingAddressDistrict;
    }

    public function setShippingAddressPostalCode($shippingAddressPostalCode)
    {
        $shippingAddressPostalCode = $this->only_numbers($shippingAddressPostalCode);
        $this->data['shippingAddressPostalCode'] = $shippingAddressPostalCode;
    }

    public function setShippingAddressCity($shippingAddressCity)
    {
        $this->data['shippingAddressCity'] = $shippingAddressCity;
    }

    public function setShippingAddressState($shippingAddressState)
    {
        $shippingAddressState = strtoupper($shippingAddressState);
        if (strlen($shippingAddressState) === 2) {
            $this->data['shippingAddressState'] = $shippingAddressState;
        }
    }


    public function setShippingAddressCountry($shippingAddressCountry)
    {
        $this->data['shippingAddressCountry'] = $shippingAddressCountry;
    }

    public function build()
    {
        $i = 1;
        foreach ($this->item as $item) {
            $this->data['itemId' . $i] = $item['id'];
            $this->data['itemDescription' . $i] = $item['description'];
            $this->data['itemAmount' . $i] = $item['amount'];
            $this->data['itemQuantity' . $i] = $item['quantity'];
            if ($item['weight']) {
                $this->data['itemWeight' . $i] = $item['weight'];
            }
            if ($item['shippingCost']) {
                $this->data['itemShippingCost' . $i] = $item['shippingCost'];
            }
            $i++;
        }

        return $this->data;
    }

    public function send()
    {
        $url = URL::getWs() . 'v2/checkout?email=' . Conf::getEmail() . '&token=' . Conf::getToken();
        $data = $this->build();

        $curl = new Curl($url, $data);
        return $data = $curl->exec();
    }

    public function checkoutCode()
    {
        $data = $this->send();
        return isset($data->code) ? $data->code : false;
    }

    public function redirectCode()
    {
        return URL::getPage() . 'v2/checkout/payment.html?code=' . $this->checkoutCode();
    }
}
