<?php

namespace Sounoob\pagseguro\directPayment;

use Sounoob\pagseguro\core\Utils;
use Sounoob\pagseguro\directPayment\core\DirectPayment;
use Sounoob\pagseguro\Installments;

class CreditCard extends DirectPayment
{
    private $creditCardBrand = 'visa';

    public function setCreditCardToken($creditCardToken)
    {
        $this->post['creditCardToken'] = $creditCardToken;
    }

    public function setBillingAddressCountry($billingAddressCountry)
    {
        $this->post['billingAddressCountry'] = $billingAddressCountry;
    }

    /**
     * @param int $postalCode
     */
    public function setBillingAddressPostalCode($postalCode)
    {
        $postalCode = Utils::onlyNumbers($postalCode);
        $this->post['billingAddressPostalCode'] = $postalCode;
    }

    /**
     * @param string $street
     * @param string $number
     * @param string|null $complement
     */
    public function setBillingAddress($street, $number = 's/n', $complement = null)
    {
        $this->post['billingAddressStreet'] = $street;
        if ($number) {
            $this->post['billingAddressNumber'] = $number;
        }
        if ($complement) {
            $this->post['billingAddressComplement'] = $complement;
        }
    }

    /**
     * @param string $district
     */
    public function setBillingDistrict($district)
    {
        $this->post['billingAddressDistrict'] = $district;
    }

    /**
     * @param string $city
     */
    public function setBillingAddressCity($city)
    {
        $this->post['billingAddressCity'] = $city;
    }

    /**
     * @param string $state
     */
    public function setBillingAddressState($state)
    {
        $state = strtoupper($state);
        $this->post['billingAddressState'] = $state;
    }

    /**
     * @param int $areaCode
     * @param int $number
     */
    public function setHolderPhone($areaCode, $number)
    {
        $this->post['creditCardHolderAreaCode'] = Utils::onlyNumbers($areaCode);
        $this->post['creditCardHolderPhone'] = Utils::onlyNumbers($number);
    }

    /**
     * @param int $cpf
     */
    public function setHolderCPF($cpf)
    {
        $cpf = Utils::onlyNumbers($cpf);
        $this->post['creditCardHolderCPF'] = $cpf;
    }
    /*
     * @todo create a setSenderCPNJ
     */

    /**
     * @param int $installmentQuantity
     * @param int $noInterestInstallmentQuantity
     * @param string $creditCardBrand
     */
    public function setInstallment($installmentQuantity, $noInterestInstallmentQuantity, $creditCardBrand)
    {
        if($installmentQuantity > 1) {
            if($noInterestInstallmentQuantity > $installmentQuantity) {
                $noInterestInstallmentQuantity = $installmentQuantity;
            }
            $this->creditCardBrand = $creditCardBrand;
            $this->post['installmentQuantity'] = $installmentQuantity;
            $this->post['noInterestInstallmentQuantity'] = $noInterestInstallmentQuantity;

            $this->calcInstallment();
        }

    }

    /**
     * @param string $name
     */
    public function setHolderName($name)
    {
        $this->post['creditCardHolderName'] = $name;
    }

    /**
     * @param string $birthdate
     */
    public function setHolderBirthDate($birthdate)
    {
        $this->post['creditCardHolderBirthDate'] = $birthdate;
    }

    protected function defaultValues()
    {
        if (!isset($this->post['paymentMethod'])) {
            $this->post['paymentMethod'] = 'creditCard';
        }
        if (!isset($this->post['installmentQuantity'])) {
            $this->post['installmentQuantity'] = 1;
        }
        $this->calcInstallmentValue();
        parent::defaultValues();
    }

    protected function requiredFields()
    {                            
        if (!isset($this->post['creditCardToken'])) {
            //PagSeguro error code 53037
            throw new \Exception('credit card token is required.')
        }
                            
        if (!isset($this->post['billingAddressStreet'])) {
            //PagSeguro error code 53055
            throw new \Exception('billing address street is required.')
        }
                            
        if (!isset($this->post['billingAddressNumber'])) {
            //PagSeguro error code 53057
            throw new \Exception('billing address number is required.')
        }
                            
        if (!isset($this->post['billingAddressDistrict'])) {
            //PagSeguro error code 53060
            throw new \Exception('billing address district is required.')
        }
                            
        if (!isset($this->post['billingAddressPostalCode'])) {
            //PagSeguro error code 53053
            throw new \Exception('billing address postal code is required.')
        }
                            
        if (!isset($this->post['creditCardHolderCPF'])) {
            //PagSeguro error code 53045
            throw new \Exception('credit card holder cpf is required.')
        }
                            
        if (!isset($this->post['billingAddressState'])) {
            //PagSeguro error code 53064
            throw new \Exception('billing address state is required.')
        }
                            
        if (!isset($this->post['billingAddressCity'])) {
            //PagSeguro error code 53062
            throw new \Exception('billing address city is required.')
        }
                            
        if (!isset($this->post['billingAddressCountry'])) {
            //PagSeguro error code 53066
            throw new \Exception('billing address country is required.')
        }
                            
        if (!isset($this->post['creditCardHolderName'])) {
            //PagSeguro error code 53042
            throw new \Exception('credit card holder name is required.')
        }
                            
        if (!isset($this->post['creditCardHolderBirthDate'])) {
            //PagSeguro error code 53047
            throw new \Exception('credit card holder birthdate is required.')
        }
                            
        if (!isset($this->post['creditCardHolderPhone'])) {
            //PagSeguro error code 53051
            throw new \Exception('credit card holder phone is required.')
        }
                            
        if (!isset($this->post['creditCardHolderAreaCode'])) {
            //PagSeguro error code 53049
            throw new \Exception('credit card holder area code is required.')
        }
        parent::requiredFields();
    }

    private function calcInstallmentValue()
    {
        $this->post['installmentValue'] = 0;

        foreach ($this->item as $item) {
            $this->post['installmentValue'] += $item['amount'] * $item['quantity'];
        }
        $this->post['installmentValue'] = number_format($this->post['installmentValue'], 2, '.', '');
    }

    private function calcInstallment()
    {
        $installment = new Installments($this->post['installmentValue'], $this->creditCardBrand, isset($this->post['noInterestInstallmentQuantity']) ? $this->post['noInterestInstallmentQuantity'] : 1);
        $installment = current($installment->result->installments);

        $this->post['installmentValue'] = $installment[$this->post['installmentQuantity'] - 1]->installmentAmount;
        $this->post['installmentValue'] = number_format($this->post['installmentValue'], 2, '.', '');

        if($this->post['noInterestInstallmentQuantity'] == 1) {
            unset($this->post['noInterestInstallmentQuantity']);
        }
    }

}