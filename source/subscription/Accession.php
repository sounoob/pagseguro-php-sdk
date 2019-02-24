<?php

namespace Sounoob\pagseguro\subscription;

use Sounoob\pagseguro\core\PagSeguro;
use Sounoob\pagseguro\core\Utils;

/**
 * Class Accession
 * @package Sounoob\pagseguro\subscription
 */
class Accession extends PagSeguro
{
    /**
     * @param string $plan
     */
    public function setPlan($plan)
    {
        $this->post['plan'] = $plan;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->post['reference'] = $reference;
    }

    /**
     * @param string $name
     */
    public function setSenderName($name)
    {
        $this->post['sender']['name'] = $name;
    }

    /**
     * @param string $email
     * @throws \Exception
     */
    public function setSenderEmail($email)
    {
        $domain = Utils::getDomainFromEmail($email);
        if ($domain === false || ($domain != 'sandbox.pagseguro.com.br' && \Sounoob\pagseguro\config\Config::isSandbox() === true)) {
            //PagSeguro error code 60800
            throw new \InvalidArgumentException('sender email invalid domain: ' . $email . '. You must use an email @sandbox.pagseguro.com.br');
        }
        $this->post['sender']['email'] = $email;
    }
    /*
     * @todo create senderIP();
     */
    /**
     * @param string $senderHash
     */
    public function setSenderHash($senderHash)
    {
        $this->post['sender']['hash'] = $senderHash;
    }

    /**
     * @param int $areaCode
     * @param int $number
     */
    public function setSenderPhone($areaCode, $number)
    {
        $this->post['sender']['phone']['areaCode'] = Utils::onlyNumbers($areaCode);
        $this->post['sender']['phone']['number'] = Utils::onlyNumbers($number);
    }

    /**
     * @param string $street
     * @param string $number
     * @param string|null $complement
     */
    public function setSenderAddress($street, $number = 's/n', $complement = null)
    {
        $this->post['sender']['address']['street'] = $street;
        if ($number) {
            $this->post['sender']['address']['number'] = $number;
        }
        if ($complement) {
            $this->post['sender']['address']['complement'] = $complement;
        }
    }

    /**
     * @param int $postalCode
     */
    public function setSenderPostalCode($postalCode)
    {
        $postalCode = Utils::onlyNumbers($postalCode);
        $this->post['sender']['address']['postalCode'] = $postalCode;
    }

    /**
     * @param string $district
     */
    public function setSenderDistrict($district)
    {
        $this->post['sender']['address']['district'] = $district;
    }

    /**
     * @param string $city
     */
    public function setSenderCity($city)
    {
        $this->post['sender']['address']['city'] = $city;
    }

    /**
     * @param string $state
     */
    public function setSenderState($state)
    {
        $state = strtoupper($state);
        if (strlen($state) != 2) {
            //PagSeguro error code 19007
            throw new \InvalidArgumentException('addressState invalid value: ' . $state . ', must fit the pattern: \w{2} (e. g. "SP")');
        }
        $this->post['sender']['address']['state'] = $state;
    }

    /**
     * @param string $street
     * @param string $number
     * @param string|null $complement
     */
    public function setHolderAddress($street, $number = 's/n', $complement = null)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['street'] = $street;
        if ($number) {
            $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['number'] = $number;
        }
        if ($complement) {
            $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['complement'] = $complement;
        }
    }

    /**
     * @param int $postalCode
     */
    public function setHolderPostalCode($postalCode)
    {
        $postalCode = Utils::onlyNumbers($postalCode);
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['postalCode'] = $postalCode;
    }

    /**
     * @param string $district
     */
    public function setHolderDistrict($district)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['district'] = $district;
    }

    /**
     * @param string $city
     */
    public function setHolderCity($city)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['city'] = $city;
    }

    /**
     * @param string $state
     */
    public function setHolderState($state)
    {
        $state = strtoupper($state);
        if (strlen($state) != 2) {
            //PagSeguro error code 19007
            throw new \InvalidArgumentException('addressState invalid value: ' . $state . ', must fit the pattern: \w{2} (e. g. "SP")');
        }
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['state'] = $state;
    }
    /*
     * @todo create a setSenderCPNJ
     */
    /**
     * @param int $cpf
     */
    public function setSenderCPF($cpf)
    {
        $cpf = Utils::onlyNumbers($cpf);

        if (!Utils::checkCPF($cpf)) {
            //PagSeguro error code 61011
            throw new \InvalidArgumentException('cpf is invalid: ' . $cpf);
        }
        $this->post['sender']['documents'][0]['type'] = 'CPF';
        $this->post['sender']['documents'][0]['value'] = $cpf;
    }

    /**
     * @param string $creditCardToken
     */
    public function setCreditCardToken($creditCardToken)
    {
        $this->post['paymentMethod']['creditCard']['token'] = $creditCardToken;
    }

    /**
     * @param string $name
     */
    public function setHolderName($name)
    {
        $this->post['paymentMethod']['creditCard']['holder']['name'] = $name;
    }

    /**
     * @param string $birthdate
     */
    public function setHolderBirthDate($birthdate)
    {
        $this->post['paymentMethod']['creditCard']['holder']['birthDate'] = $birthdate;
    }

    /**
     * @param int $cpf
     */
    public function setHolderCPF($cpf)
    {
        $cpf = Utils::onlyNumbers($cpf);

        if (!Utils::checkCPF($cpf)) {
            //PagSeguro error code 61011
            throw new \InvalidArgumentException('cpf is invalid: ' . $cpf);
        }
        $this->post['paymentMethod']['creditCard']['holder']['documents'][0]['type'] = 'CPF';
        $this->post['paymentMethod']['creditCard']['holder']['documents'][0]['value'] = $cpf;
    }

    /**
     * @param int $areaCode
     * @param int $number
     */
    public function setHolderPhone($areaCode, $number)
    {
        $this->post['paymentMethod']['creditCard']['holder']['phone']['areaCode'] = Utils::onlyNumbers($areaCode);
        $this->post['paymentMethod']['creditCard']['holder']['phone']['number'] = Utils::onlyNumbers($number);
    }

    /**
     * @throws \Exception
     */
    protected function requiredFields()
    {
        if (!isset($this->post['plan'])) {
            //PagSeguro error code 17061
            throw new \Exception('Plan not found.');
        }
        if (!isset($this->post['sender']['name'])) {
            //PagSeguro error code 10049
            throw new \Exception('senderName mandatory.');
        }
        if (!isset($this->post['sender']['email'])) {
            //PagSeguro error code 10050
            throw new \Exception('senderEmail mandatory.');
        }
        if (!isset($this->post['sender']['phone']['number'])) {
            //PagSeguro error code 10027
            throw new \Exception('senderPhone empty or blank.');
        }
        if (!isset($this->post['sender']['phone']['areaCode'])) {
            //PagSeguro error code 10028
            throw new \Exception('senderAreaCode empty or blank.');
        }
        if (!isset($this->post['sender']['documents'])) {
            //PagSeguro error code 17065
            throw new \Exception('Documents required.');
        }
        if (!isset($this->post['sender']['hash']) && !isset($this->post['sender']['id'])) {
            //PagSeguro error code 17093
            throw new \Exception('Sender hash or IP is required.');
        }
        if (!isset($this->post['sender']['address']['street'])) {
            //PagSeguro error code 57038
            throw new \Exception('address state is required.');
        }
        if (!isset($this->post['sender']['address']['postalCode'])) {
            //PagSeguro error code 50103
            throw new \Exception('postal code can not be empty.');
        }
        if (!isset($this->post['sender']['address']['district'])) {
            //PagSeguro error code 50106
            throw new \Exception('address district can not be empty.');
        }
        if (!isset($this->post['sender']['address']['city'])) {
            //PagSeguro error code 50108
            throw new \Exception('address city can not be empty.');
        }
        if (!isset($this->post['sender']['address']['state'])) {
            //PagSeguro error code 57038
            throw new \Exception('address state can not be empty.');
        }
    }

    protected function defaultValues()
    {
        if (!isset($this->post['paymentMethod']['type'])) {
            $this->post['paymentMethod']['type'] = 'CREDITCARD';
        }
        if (!isset($this->post['paymentMethod']['creditCard']['holder']['name'])) {
            $this->post['paymentMethod']['creditCard']['holder']['name'] = $this->post['sender']['name'];
        }
        if (!isset($this->post['paymentMethod']['creditCard']['holder']['phone']['areaCode'])) {
            $this->post['paymentMethod']['creditCard']['holder']['phone']['areaCode'] = $this->post['sender']['phone']['areaCode'];
        }
        if (!isset($this->post['paymentMethod']['creditCard']['holder']['phone']['number'])) {
            $this->post['paymentMethod']['creditCard']['holder']['phone']['number'] = $this->post['sender']['phone']['number'];
        }
        if (!isset($this->post['paymentMethod']['creditCard']['holder']['documents'][0]['type'])) {
            $this->post['paymentMethod']['creditCard']['holder']['documents'][0]['type'] = $this->post['sender']['documents'][0]['type'];
        }
        if (!isset($this->post['paymentMethod']['creditCard']['holder']['documents'][0]['value'])) {
            $this->post['paymentMethod']['creditCard']['holder']['documents'][0]['value'] = $this->post['sender']['documents'][0]['value'];
        }
        if (!isset($this->post['sender']['address']['country'])) {
            $this->post['sender']['address']['country'] = 'BRA';
        }
        if (isset($this->post['paymentMethod']['creditCard']['holder']['billingAddress'])) {
            $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['country'] = 'BRA';
        }
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->url = 'pre-approvals';
        $this->curl->setContentType('application/json;charset=UTF-8');
        $this->curl->setAccept('application/vnd.pagseguro.com.br.v1+json;charset=ISO-8859-1');
        return parent::send();
    }
}