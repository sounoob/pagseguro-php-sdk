<?php

include_once "Config.php";
include_once "Utils.php";
include_once "Curl.php";

class Boleto
{
    private $data = array();

    public function setCustomerCPF($data)
    {
        $data = Utils::onlyNumbers($data);

        if (strlen($data) !== 11) {
            //PagSeguro error code 1114
            throw new InvalidArgumentException('customer document value is invalid. it must be a valid CPF: ' . $data);
        }
        $this->data['customer']['document']['type'] = 'CPF';
        $this->data['customer']['document']['value'] = $data;
    }

    public function setCustomerCNPJ($data)
    {
        $data = Utils::onlyNumbers($data);

        if (strlen($data) !== 14) {
            //PagSeguro error code 1115
            throw new InvalidArgumentException('customer document value is invalid. it must be a valid CNPJ: ' . $data);
        }
        $this->data['customer']['document']['type'] = 'CNPJ';
        $this->data['customer']['document']['value'] = $data;
    }

    public function setCustomerName($data)
    {
        if (strlen($data) > 50) {
            //PagSeguro error code 1121
            throw new InvalidArgumentException('name size is invalid. the maximum size is 50 characters: ' . $data);
        }
        $this->data['customer']['name'] = $data;
    }

    public function setCustomerEmail($data)
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            //PagSeguro error code 1132
            throw new InvalidArgumentException('email is invalid. it must be a valid format e-mail: ' . $data);
        }
        if (strlen($data) > 60) {
            //PagSeguro error code 1131
            throw new InvalidArgumentException('email size is invalid. the maximum size is 60 characters: ' . $data);
        }
        $this->data['customer']['email'] = $data;
    }

    public function setCustomerPhone($areaCode, $number)
    {
        $areaCode = Utils::onlyNumbers($areaCode);
        $areaCode = substr($areaCode, 0, 2);

        $number = Utils::onlyNumbers($number);
        $number = substr($number, 0, 9);

        if (strlen($areaCode) !== 2) {
            //PagSeguro error code 1151
            throw new InvalidArgumentException('phone areaCode is invalid. it must be 2 digits: ' . $areaCode);
        }

        if (strlen($number) < 8 || strlen($number) > 9) {
            //PagSeguro error code 1161
            throw new InvalidArgumentException('phone number is invalid. it must be 8 or 9 digits without separator: ' . $number);
        }

        $this->data['customer']['phone']['areaCode'] = $areaCode;
        $this->data['customer']['phone']['number'] = $number;
    }

    public function setReference($data)
    {
        if (strlen($data) > 200) {
            //PagSeguro error code 1001
            throw new InvalidArgumentException('maximum reference size is 200: ' . $data);
        }
        $this->data['reference'] = $data;
    }

    public function setFirstDueDate($data)
    {
        $this->data['firstDueDate'] = $data;
    }

    public function setNumberOfPayments($data)
    {
        $data = Utils::onlyNumbers($data);

        if ($data < 1 || $data > 12) {
            //PagSeguro error code 1021
            throw new InvalidArgumentException('numberOfPayments is invalid. it must have only numbers (0-9) and value between 1 to 12.: ' . $data);
        }
        $this->data['numberOfPayments'] = $data;
    }

    public function setAmount($data)
    {
        $data = (double)$data;
        if ($data < 5 || $data > 1000000) {
            //PagSeguro error code 1041
            throw new InvalidArgumentException('amount is invalid. it is allowed value between 5.00 to 1000000.00.: ' . $data);
        }
        $this->data['amount'] = $data;
    }

    public function setDescription($data)
    {
        if (strlen($data) > 100) {
            //PagSeguro error code 1061
            throw new InvalidArgumentException('description is invalid. the maximum size is 100 characters: ' . $data);
        }
        $this->data['description'] = $data;
    }

    public function setInstructions($data)
    {
        if (strlen($data) > 100) {
            //PagSeguro error code 1050
            throw new InvalidArgumentException('instructions is invalid. the maximum size is 100 characters: ' . $data);
        }
        $this->data['instructions'] = $data;
    }

    public function setNotificationURL($data)
    {
        if (strlen($data) > 255 || !filter_var($data, FILTER_VALIDATE_URL)) {
            //PagSeguro error code 1070
            //erro 500 when dont use http and is close to maximum size
            throw new InvalidArgumentException('notificarionURL is invalid. the maximum size is 255 characters and should be a valid url ' . $data);
        }
        $this->data['notificationURL'] = $data;
    }
    /*
     * @todo check address erros.
     */
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
        $data = Utils::onlyNumbers($data);
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

    private function requiredFields()
    {
        if (!isset($this->data['amount'])) {
            //PagSeguro error code 1040
            throw new Exception('amount is required');
        }
        if (!isset($this->data['description'])) {
            //PagSeguro error code 1060
            throw new Exception('description is required');
        }
        if (!isset($this->data['customer']['document'])) {
            //PagSeguro error code 1110
            throw new Exception('customer document is required');
        }
        if (!isset($this->data['customer']['document']['type'])) {
            //prevents erro 500
            throw new Exception('customer document type is required');
        }
        if (!isset($this->data['customer']['document']['value'])) {
            //PagSeguro error code 1113
            throw new Exception('customer document value is required');
        }
        if (!isset($this->data['customer']['name'])) {
            //PagSeguro error code 1120
            throw new Exception('name is required');
        }
        if (!isset($this->data['customer']['email'])) {
            //PagSeguro error code 1130
            throw new Exception('email is required');
        }
        if (!isset($this->data['customer']['phone'])) {
            //PagSeguro error code 1140
            throw new Exception('customer phone is required');
        }
    }

    private function requiredFieldsButNot()
    {
        if (!isset($this->data['periodicity'])) {
            $this->data['periodicity'] = 'monthly';
        }
        if (!isset($this->data['numberOfPayments'])) {
            $this->data['numberOfPayments'] = 1;
        }
        if (!isset($this->data['reference'])) {
            $this->data['reference'] = 'generated automatically in: ' . date('r');
        }
        if (!isset($this->data['firstDueDate'])) {
            $this->data['firstDueDate'] = date("Y-m-d", strtotime("+3 days", time()));
        }
    }

    public function build()
    {
        $this->requiredFields();
        $this->requiredFieldsButNot();

        return $this->data;
    }

    public function send()
    {
        if (Conf::isSandbox()) {
            throw new Exception('API is not available in sandbox envolviment');
        }
        $url = URL::getWs() . 'recurring-payment/boletos?email=' . Conf::getEmail() . '&token=' . Conf::getToken();
        $data = $this->build();

        $curl = new Curl($url);
        $curl->setData($data, 'json');
        $curl->setContentType('application/json;charset=ISO-8859-1');
        $curl->setAccept('application/json;charset=ISO-8859-1');
        return $curl->exec();
    }
}
