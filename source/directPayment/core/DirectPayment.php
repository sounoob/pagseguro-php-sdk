<?php

namespace Sounoob\pagseguro\directPayment\core;

use Sounoob\pagseguro\core\PagSeguro;
use Sounoob\pagseguro\core\Utils;

/**
 * Class Directpayment
 * @package Sounoob\pagseguro\directpayment\core
 */
class DirectPayment extends PagSeguro
{
    /**
     * @var array
     */
    protected $item = array();

    /**
     * @param string $id
     * @param string $description
     * @param int $quantity
     * @param double $amount
     * @param int $weight
     */
    public function addItem($id, $description, $quantity, $amount, $weight = 0)
    {
        /*
         * @todo force $amount to be \d+.\d{2}, (try to do in all project);
         */
        $this->item[] = array(
            'id' => $id,
            'amount' => $amount,
            'description' => $description,
            'quantity' => $quantity,
            'weight' => $weight,
        );
    }

    /**
     * @param string $receiverEmail
     */
    public function setReceiverEmail($receiverEmail)
    {
        /*
         * @todo Force valid e-mail (check it in all project)
         */
        $this->post['receiverEmail'] = $receiverEmail;
    }

    /**
     * @param string senderHash
     */
    public function setSenderHash($senderHash)
    {
        $this->post['senderHash'] = $senderHash;
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
        $this->post['senderName'] = $name;
    }

    /**
     * @param string $email
     * @throws \Exception
     */
    public function setSenderEmail($email)
    {
        $domain = Utils::getDomainFromEmail($email);
        if ($domain === false || ($domain != 'sandbox.pagseguro.com.br' && \Sounoob\pagseguro\config\Config::isSandbox() === true)) {
            //PagSeguro error code 53122
            throw new \InvalidArgumentException('sender email invalid domain: ' . $email . '. You must use an email @sandbox.pagseguro.com.br');
        }
        $this->post['senderEmail'] = $email;
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
            //PagSeguro error code 53017
            throw new \InvalidArgumentException('sender cpf invalid value: ' . $cpf);
        }
        $this->post['senderCPF'] = $cpf;
    }

    /**
     * @param double $extraAmount
     */
    public function setExtraAmount($extraAmount)
    {
        $this->post['extraAmount'] = $extraAmount;
    }

    /**
     * @param bool $skip
     */
    public function skipAddress($skip = true)
    {
        $this->post['shippingAddressRequired'] = $skip === true ? 'false' : 'true';
    }

    /**
     * @param string $notificationURL
     */
    public function setNotificationURL($notificationURL)
    {
        /*
         * @todo Force valid URL (check it in all project)
         */
        $this->post['notificationURL'] = $notificationURL;
    }

    /**
     * @param int $shippingType
     */
    private function setShippingType($shippingType)
    {
        $this->post['shippingType'] = $shippingType;
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
     * @return array
     * @throws \Exception
     */
    public function build()
    {
        foreach ($this->post as $key => $row) {
            if (isset($this->post['shippingAddressRequired']) === true
                && $this->post['shippingAddressRequired'] === true
                && strpos($key, 'shipping') !== false
                && $key != 'shippingAddressRequired') {
                /*
                 * @todo test this case in PagSeguro
                 */
                //PagSeguro error code 11057
                throw new \Exception('sender address not required with address data filled: ' . $key);
            }
        }
        $this->buildItem();
        parent::build();

        return $this->post;
    }

    /**
     *
     */
    protected function buildItem()
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
            $count++;
        }
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->url = 'v2/transactions';
        $this->curl->setContentType('application/x-www-form-urlencoded;charset=UTF-8');
        return parent::send();
    }

    /**
     * @throws \Exception
     */
    protected function requiredFields()
    {
        if (!isset($this->post['itemId1'])) {
            //PagSeguro error code 53004
            throw new \Exception('items invalid quantity.');
        }
        if (!isset($this->post['senderName'])) {
            //PagSeguro error code 53013
            throw new \Exception('sender name is required.');
        }
        if (!isset($this->post['senderEmail'])) {
            //PagSeguro error code 53010
            throw new \Exception('sender email is required.');
        }
        if (!isset($this->post['senderPhone'])) {
            //PagSeguro error code 53020
            throw new \Exception('sender phone is required.');
        }
        if (!isset($this->post['senderCPF'])) {
            //PagSeguro error code 53118
            throw new \Exception('sender CPF or sender CNPJ is required.');
        }
    }

    protected function defaultValues()
    {
        if (!isset($this->post['paymentMode'])) {
            $this->post['paymentMode'] = 'default';
        }
        if (!isset($this->post['currency'])) {
            $this->post['currency'] = 'BRL';
        }
        if (!isset($this->post['shippingAddressRequired'])) {
            $this->post['shippingAddressRequired'] = true;
        }
    }
}