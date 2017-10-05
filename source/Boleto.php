<?php

include_once "Config.php";
include_once "Utils.php";
include_once "Curl.php";

class Boleto extends Utils
{
    private $data = array();

    public function setCustomerCPF($data)
    {
        $this->data['customer']['document']['type'] = 'CPF';
        $this->data['customer']['document']['value'] = $data;
    }

    public function setCustomerName($data)
    {
        //@todo test maximum lenght
        $this->data['customer']['name'] = $data;
    }
    public function setCustomerEmail($data)
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            //PagSeguro error code 53012
            throw new InvalidArgumentException('sender email invalid value: ' . $data);
        }
        $this->data['customer']['email'] = $data;
    }

    public function setCustomerPhone($areaCode, $number)
    {
        $areaCode = $this->only_numbers($areaCode);
        $areaCode = substr($areaCode, 0, 2);

        $number = $this->only_numbers($number);
        $number = substr($number, 0, 9);

        $this->data['customer']['phone']['areaCode'] = $areaCode;
        $this->data['customer']['phone']['number'] = $number;
    }

    public function setReference($data)
    {
        $this->data['reference'] = $data;
    }

    public function setFirstDueDate($data)
    {
        $this->data['firstDueDate'] = $data;
    }

    public function setNumberOfPayments($data)
    {
        $data = $this->only_numbers($data);

        if($data < 1 || $data > 12) {
            //PagSeguro error code 1021
            throw new InvalidArgumentException('numberOfPayments is invalid. it must have only numbers (0-9) and value between 1 to 12.');
        }
        $this->data['numberOfPayments'] = $data;
    }

    public function setAmount($data)
    {
        $data = (double) $data;
        if($data < 5 || $data > 1000000) {
            //PagSeguro error code 1041
            throw new InvalidArgumentException('amount is invalid. it is allowed value between 5.00 to 1000000.00.');
        }
        $this->data['amount'] = $data;
    }

    public function setDescription($data)
    {
        //@todo test maximum lenght
        $this->data['description'] = $data;
    }

    public function setInstructions($data)
    {
        $this->data['instructions'] = $data;
    }
    public function __construct()
    {
    }

    public function setCustomerAddressStreet($data)
    {
        $this->data['customer']['address']['street'] = $data;
    }

    public function setCustomerAddressNumber($data)
    {
        $this->data['customer']['address']['number'] = $data;
    }

    public function setCustomerAddressDistrict($data)
    {
        $this->data['customer']['address']['district'] = $data;
    }

    public function setCustomerAddressPostalCode($data)
    {
        $data = $this->only_numbers($data);
        $this->data['customer']['address']['postalCode'] = $data;
    }

    public function setCustomerAddressCity($data)
    {
        $this->data['customer']['address']['city'] = $data;
    }

    public function setCustomerAddressState($data)
    {
        $data = strtoupper($data);
        if (strlen($data) === 2) {
            $this->data['customer']['address']['state'] = $data;
        }
    }

    public function build()
    {
        if(!isset($this->data['periodicity'])) {
            $this->data['periodicity'] = 'monthly';
        }
        if(!isset($this->data['numberOfPayments'])) {
            $this->data['numberOfPayments'] = 1;
        }
        if(!isset($this->data['reference'])) {
            $this->data['reference'] = date("YmdHis");
        }
        if(!isset($this->data['firstDueDate'])) {
            $this->data['firstDueDate'] = date("Y-m-d", strtotime("+3 days", time()));
        }

        return $this->data;
    }

    public function send()
    {
        $url = URL::getWs() . 'recurring-payment/boletos?email=' . Conf::getEmail() . '&token=' . Conf::getToken();
        $data = $this->build();

        $curl = new Curl($url);
        $curl->setData($data, 'json');
        $curl->setContentType('application/json;charset=ISO-8859-1');
        $curl->setAccept('application/json;charset=ISO-8859-1');
        return $data = $curl->exec();
    }
}
