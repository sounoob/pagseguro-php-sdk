<?php
namespace Sounoob\pagseguro\subscription;

use Sounoob\pagseguro\core\PagSeguro;

class Accession extends PagSeguro
{
    public function setPlan($data)
    {
        $this->post['plan'] = $data;
    }
    public function setReference($data)
    {
        $this->post['reference'] = $data;
    }
    public function setSenderName($data)
    {
        $this->post['sender']['name'] = $data;
    }
    public function setSenderEmail($data)
    {
        $domain = \Sounoob\pagseguro\core\Utils::getDomainFromEmail($data);
        if ($domain === false || ($domain != 'sandbox.pagseguro.com.br' && \Sounoob\pagseguro\config\Config::isSandbox() === true)) {
            //PagSeguro error code 60800
            throw new \InvalidArgumentException('sender email invalid domain: ' . $data . '. You must use an email @sandbox.pagseguro.com.br');
        }
        $this->post['sender']['email'] = $data;
    }
    /*
     * @todo create senderIP();
     */
    public function setSenderHash($data)
    {
        $this->post['sender']['hash'] = $data;
    }
    public function setSenderPhone($areaCode, $number)
    {
        $this->post['sender']['phone']['areaCode'] = \Sounoob\pagseguro\core\Utils::onlyNumbers($areaCode);
        $this->post['sender']['phone']['number'] = \Sounoob\pagseguro\core\Utils::onlyNumbers($number);
    }
    public function setSenderAddress($street, $number = 's/n', $complement = null)
    {
        $this->post['sender']['address']['street'] = $street;
        if($number) {
            $this->post['sender']['address']['number'] = $number;
        }
        if($complement) {
            $this->post['sender']['address']['complement'] = $complement;
        }
    }
    public function setSenderPostalCode($data)
    {
        $this->post['sender']['address']['postalCode'] = $data;
    }
    public function setSenderDistrict($data)
    {
        $this->post['sender']['address']['district'] = $data;
    }
    public function setSenderCity($data)
    {
        $this->post['sender']['address']['city'] = $data;
    }
    public function setSenderState($data)
    {
        $data = strtoupper($data);
        if (strlen($data) != 2) {
            //PagSeguro error code 19007
            throw new \InvalidArgumentException('addressState invalid value: ' . $data . ', must fit the pattern: \w{2} (e. g. "SP")');
        }
        $this->post['sender']['address']['state'] = $data;
    }    
    public function setHolderAddress($street, $number = 's/n', $complement = null)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['street'] = $street;
        if($number) {
            $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['number'] = $number;
        }
        if($complement) {
            $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['complement'] = $complement;
        }
    }
    public function setHolderPostalCode($data)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['postalCode'] = $data;
    }
    public function setHolderDistrict($data)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['district'] = $data;
    }
    public function setHolderCity($data)
    {
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['city'] = $data;
    }
    public function setHolderState($data)
    {
        $data = strtoupper($data);
        if (strlen($data) != 2) {
            //PagSeguro error code 19007
            throw new \InvalidArgumentException('addressState invalid value: ' . $data . ', must fit the pattern: \w{2} (e. g. "SP")');
        }
        $this->post['paymentMethod']['creditCard']['holder']['billingAddress']['state'] = $data;
    }
     /*
      * @todo create a setSenderCPNJ
      */
    public function setSenderCPF($data)
    {
        $data = \Sounoob\pagseguro\core\Utils::onlyNumbers($data);
        
        if (!\Sounoob\pagseguro\core\Utils::checkCPF($data)) {
            //PagSeguro error code 61011
            throw new \InvalidArgumentException('cpf is invalid: ' . $data);
        }
        $this->post['sender']['documents'][0]['type'] = 'CPF';
        $this->post['sender']['documents'][0]['value'] = $data;
    }
    public function setCreditCardToken($data)
    {
        $this->post['paymentMethod']['creditCard']['token'] = $data;
    }
    public function setHolderName($data)
    {
        $this->post['paymentMethod']['creditCard']['holder']['name'] = $data;
    }
    public function setHolderBirthDate($data)
    {
        $this->post['paymentMethod']['creditCard']['holder']['birthDate'] = $data;
    }
    public function setHolderCPF($data)
    {
        $data = \Sounoob\pagseguro\core\Utils::onlyNumbers($data);
        
        if (!\Sounoob\pagseguro\core\Utils::checkCPF($data)) {
            //PagSeguro error code 61011
            throw new \InvalidArgumentException('cpf is invalid: ' . $data);
        }
        $this->post['paymentMethod']['creditCard']['holder']['documents'][0]['type'] = 'CPF';
        $this->post['paymentMethod']['creditCard']['holder']['documents'][0]['value'] = $data;
    }
    public function setHolderPhone($areaCode, $number)
    {
        $this->post['paymentMethod']['creditCard']['holder']['phone']['areaCode'] = \Sounoob\pagseguro\core\Utils::onlyNumbers($areaCode);
        $this->post['paymentMethod']['creditCard']['holder']['phone']['number'] = \Sounoob\pagseguro\core\Utils::onlyNumbers($number);
    }
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
    
    public function send()
    {
        $this->url = 'pre-approvals';
        $this->curl->setContentType('application/json;charset=UTF-8');
        $this->curl->setAccept('application/vnd.pagseguro.com.br.v1+json;charset=ISO-8859-1');
        parent::send();
    }
}