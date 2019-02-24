<?php

namespace Sounoob\pagseguro;

use Sounoob\pagseguro\config\Config;
use Sounoob\pagseguro\core\PagSeguro;
use Sounoob\pagseguro\core\Utils;

/**
 * Class Boleto
 * @package Sounoob\pagseguro
 */
class Boleto extends PagSeguro
{
    /**
     * @param int $cpf
     */
    public function setCustomerCPF($cpf)
    {
        $cpf = Utils::onlyNumbers($cpf);

        if (!Utils::checkCPF($cpf)) {
            //PagSeguro error code 1114
            throw new \InvalidArgumentException('customer document value is invalid. it must be a valid CPF: ' . $cpf);
        }
        $this->post['customer']['document']['type'] = 'CPF';
        $this->post['customer']['document']['value'] = $cpf;
    }

    /**
     * @param int $cnpj
     */
    public function setCustomerCNPJ($cnpj)
    {
        $cnpj = Utils::onlyNumbers($cnpj);

        if (strlen($cnpj) !== 14) {
            //PagSeguro error code 1115
            throw new \InvalidArgumentException('customer document value is invalid. it must be a valid CNPJ: ' . $cnpj);
        }
        $this->post['customer']['document']['type'] = 'CNPJ';
        $this->post['customer']['document']['value'] = $cnpj;
    }

    /**
     * @param string $name
     */
    public function setCustomerName($name)
    {
        if (strlen($name) > 50) {
            //PagSeguro error code 1121
            throw new \InvalidArgumentException('name size is invalid. the maximum size is 50 characters: ' . $name);
        }
        $this->post['customer']['name'] = $name;
    }

    /**
     * @param string $email
     */
    public function setCustomerEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //PagSeguro error code 1132
            throw new \InvalidArgumentException('email is invalid. it must be a valid format e-mail: ' . $email);
        }
        if (strlen($email) > 60) {
            //PagSeguro error code 1131
            throw new \InvalidArgumentException('email size is invalid. the maximum size is 60 characters: ' . $email);
        }
        $this->post['customer']['email'] = $email;
    }

    /**
     * @param int $areaCode
     * @param int $number
     */
    public function setCustomerPhone($areaCode, $number)
    {
        $areaCode = Utils::onlyNumbers($areaCode);
        $areaCode = substr($areaCode, 0, 2);

        $number = Utils::onlyNumbers($number);
        $number = substr($number, 0, 9);

        if (strlen($areaCode) !== 2) {
            //PagSeguro error code 1151
            throw new \InvalidArgumentException('phone areaCode is invalid. it must be 2 digits: ' . $areaCode);
        }

        if (strlen($number) < 8 || strlen($number) > 9) {
            //PagSeguro error code 1161
            throw new \InvalidArgumentException('phone number is invalid. it must be 8 or 9 digits without separator: ' . $number);
        }

        $this->post['customer']['phone']['areaCode'] = $areaCode;
        $this->post['customer']['phone']['number'] = $number;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        if (strlen($reference) > 200) {
            //PagSeguro error code 1001
            throw new \InvalidArgumentException('maximum reference size is 200: ' . $reference);
        }
        $this->post['reference'] = $reference;
    }

    /**
     * @param string $firstDueDate
     */
    public function setFirstDueDate($firstDueDate)
    {
        $this->post['firstDueDate'] = $firstDueDate;
    }

    /**
     * @param int $numberOfPayments
     */
    public function setNumberOfPayments($numberOfPayments)
    {
        $numberOfPayments = Utils::onlyNumbers($numberOfPayments);

        if ($numberOfPayments < 1 || $numberOfPayments > 12) {
            //PagSeguro error code 1021
            throw new \InvalidArgumentException('numberOfPayments is invalid. it must have only numbers (0-9) and value between 1 to 12.: ' . $numberOfPayments);
        }
        $this->post['numberOfPayments'] = $numberOfPayments;
    }

    /**
     * @param double $amount
     */
    public function setAmount($amount)
    {
        $amount = (double)$amount;
        if ($amount < 5 || $amount > 1000000) {
            //PagSeguro error code 1041
            throw new \InvalidArgumentException('amount is invalid. it is allowed value between 5.00 to 1000000.00.: ' . $amount);
        }
        $this->post['amount'] = $amount;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        if (strlen($description) > 100) {
            //PagSeguro error code 1061
            throw new \InvalidArgumentException('description is invalid. the maximum size is 100 characters: ' . $description);
        }
        $this->post['description'] = $description;
    }

    /**
     * @param string $instructions
     */
    public function setInstructions($instructions)
    {
        if (strlen($instructions) > 100) {
            //PagSeguro error code 1050
            throw new \InvalidArgumentException('instructions is invalid. the maximum size is 100 characters: ' . $instructions);
        }
        $this->post['instructions'] = $instructions;
    }

    /**
     * @param string $url
     */
    public function setNotificationURL($url)
    {
        if (strlen($url) > 255 || !filter_var($url, FILTER_VALIDATE_URL)) {
            //PagSeguro error code 1070
            //erro 500 when dont use http and is close to maximum size
            throw new \InvalidArgumentException('notificarionURL is invalid. the maximum size is 255 characters and should be a valid url ' . $url);
        }
        $this->post['notificationURL'] = $url;
    }
    /*
     * @todo check address erros.
     */
    /**
     * @param string $street
     * @deprecated
     */
    public function setCustomerAddressStreet($string)
    {
        $this->post['customer']['address']['street'] = $string;
    }

    /**
     * @param string $number
     * @deprecated
     */
    public function setCustomerAddressNumber($number)
    {
        $this->post['customer']['address']['number'] = $number;
    }

    /**
     * @param string $street
     * @param string $number
     */
    public function setCustomerAddress($street, $number = 's\n')
    {
        $this->post['customer']['address']['street'] = $street;
        $this->post['customer']['address']['number'] = $number;
    }

    /**
     * @param string $district
     */
    public function setCustomerAddressDistrict($district)
    {
        $this->post['customer']['address']['district'] = $district;
    }

    /**
     * @param int $postalCode
     */
    public function setCustomerAddressPostalCode($postalCode)
    {
        $postalCode = Utils::onlyNumbers($postalCode);
        $this->post['customer']['address']['postalCode'] = $postalCode;
    }

    /**
     * @param string $city
     */
    public function setCustomerAddressCity($city)
    {
        $this->post['customer']['address']['city'] = $city;
    }

    /**
     * @param string $state
     */
    public function setCustomerAddressState($state)
    {
        /*
         * @todo throw exeption if is not 2 char
         */
        $state = strtoupper($state);
        if (strlen($state) === 2) {
            $this->post['customer']['address']['state'] = $state;
        }
    }
    protected function requiredFields()
    {
        if (!isset($this->post['amount'])) {
            //PagSeguro error code 1040
            throw new Exception('amount is required');
        }
        if (!isset($this->post['description'])) {
            //PagSeguro error code 1060
            throw new Exception('description is required');
        }
        if (!isset($this->post['customer']['document'])) {
            //PagSeguro error code 1110
            throw new Exception('customer document is required');
        }
        if (!isset($this->post['customer']['document']['type'])) {
            //prevents erro 500
            throw new Exception('customer document type is required');
        }
        if (!isset($this->post['customer']['document']['value'])) {
            //PagSeguro error code 1113
            throw new Exception('customer document value is required');
        }
        if (!isset($this->post['customer']['name'])) {
            //PagSeguro error code 1120
            throw new Exception('name is required');
        }
        if (!isset($this->post['customer']['email'])) {
            //PagSeguro error code 1130
            throw new Exception('email is required');
        }
        if (!isset($this->post['customer']['phone'])) {
            //PagSeguro error code 1140
            throw new Exception('customer phone is required');
        }
    }
    protected function defaultValues()
    {
        if (!isset($this->post['periodicity'])) {
            $this->post['periodicity'] = 'monthly';
        }
        if (!isset($this->post['numberOfPayments'])) {
            $this->post['numberOfPayments'] = 1;
        }
        if (!isset($this->post['reference'])) {
            $this->post['reference'] = 'generated automatically in: ' . date('r');
        }
        if (!isset($this->post['firstDueDate'])) {
            $this->post['firstDueDate'] = date("Y-m-d", strtotime("+3 days", time()));
        }
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        if (Config::isSandbox()) {
            throw new \Exception('API is not available in sandbox environment');
        }
        $this->url = 'recurring-payment/boletos';
        $this->curl->setContentType('application/json;charset=UTF-8');
        return parent::send();
    }
}
