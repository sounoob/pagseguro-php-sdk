<?php

include_once "Utils.php";

class Payment extends Utils
{

    private $endpoint = 'https://ws.pagseguro.uol.com.br/v2/checkout';
    private $email = 'email@email.com.br';
    private $token = '90sdf89s0df89s0df89s0dfjds';
    private $currency = 'BRL';
    private $item = array();
    private $extraAmount;
    private $reference;
    private $senderName;
    private $senderCPF;
    private $senderPhone;
    private $senderEmail;
    private $shippingType;
    private $shippingAddressStreet;
    private $shippingAddressNumber;
    private $shippingAddressComplement;
    private $shippingAddressDistrict;
    private $shippingAddressPostalCode;
    private $shippingAddressCity;
    private $shippingAddressState;
    private $shippingAddressCountry;
    private $redirectURL;


    public function __construct()
    {
    }

    public function additens($itens)
    {
        foreach ($itens as $row){
            $this->addItem($row['id'],$row['description'],$row['quantity'],$row['amount'],$row['weight'],$row['shippingCost']);
        }

    }


    public function addItem($id = null,$description = "",$quantity = 0,$amount = 0,$weight = null, $shippingCost = null)
    {
        $item = new StdClass;
        $item->id= $id;
        $item->amount = $amount;
        $item->description = $description;
        $item->quantity = $quantity;
        $item->weight = $weight;
        $item->shippingCost =$shippingCost;
        array_push($this->item, $item);
        return $this->item;
    }

    public function setExtraAmount($extraAmount)
    {
        $this->extraAmount = $extraAmount;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setRedirectUrl($url)
    {
        $this->redirectURL = $url;
    }

    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    public function setSenderCPF($senderCPF)
    {
        $senderCPF = $this->only_numbers($senderCPF);
        $senderCPF = substr($senderCPF,0, 11);
        $this->senderCPF = $senderCPF;
    }

    public function setSenderAreaCode($senderAreaCode)
    {
        $senderAreaCode = $this->only_numbers($senderAreaCode);
        $this->senderAreaCode = $senderAreaCode;
    }

    public function setSenderPhone($senderAreaCode,$senderPhone)
    {
        $senderAreaCode = $this->only_numbers($senderAreaCode);
        $senderAreaCode = substr($senderAreaCode,0, 2);
        $senderPhone = $this->only_numbers($senderPhone);
        $senderPhone = substr($senderPhone,0, 9);

        $senderPhone = $senderAreaCode.$senderPhone;
        $this->senderPhone = $senderPhone;
    }

    public function setSenderEmail($senderEmail)
    {
        $senderEmail = filter_var($senderEmail, FILTER_VALIDATE_EMAIL);
        $this->senderEmail = $senderEmail;
    }

    public function setShippingType($shippingType)
    {
        $array = array(
            '1',
            '2',
            '3'
        );
        if(in_array($shippingType ,$array)){
            $this->shippingType = $shippingType;
        }

    }

    public function setShippingAddressStreet($shippingAddressStreet)
    {
        $this->shippingAddressStreet = $shippingAddressStreet;
    }

    public function setShippingAddressNumber($shippingAddressNumber)
    {
        $this->shippingAddressNumber = $shippingAddressNumber;
    }

    public function setShippingAddressComplement($shippingAddressComplement)
    {
        $this->shippingAddressComplement = $shippingAddressComplement;
    }

    public function setShippingAddressDistrict($shippingAddressDistrict)
    {
        $this->shippingAddressDistrict = $shippingAddressDistrict;
    }

    public function setShippingAddressPostalCode($shippingAddressPostalCode)
    {
        $shippingAddressPostalCode = $this->only_numbers($shippingAddressPostalCode);
        $this->shippingAddressPostalCode = $shippingAddressPostalCode;
    }

    public function setShippingAddressCity($shippingAddressCity)
    {
        $this->shippingAddressCity = $shippingAddressCity;
    }

    public function setShippingAddressState($shippingAddressState)
    {
        $shippingAddressState = strtoupper($shippingAddressState);
        if(strlen($shippingAddressState) === 2){
            $this->shippingAddressState = $shippingAddressState;
        }
    }


    public function setShippingAddressCountry($shippingAddressCountry)
    {
        $this->shippingAddressCountry = $shippingAddressCountry;
    }
}