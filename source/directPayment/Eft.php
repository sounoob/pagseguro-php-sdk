<?php

namespace Sounoob\pagseguro\directPayment;

use Sounoob\pagseguro\directPayment\core\DirectPayment;

class Eft extends DirectPayment
{
    protected function defaultValues()
    {
        if (!isset($this->post['paymentMethod'])) {
            $this->post['paymentMethod'] = 'eft';
        }
        parent::defaultValues();
    }

    protected function requiredFields()
    {
        if (!isset($this->post['bankName'])) {
            //PagSeguro error code 53111
            throw new \Exception('eft bank is not accepted.');
        }
        parent::requiredFields();
    }

    public function setBankItau()
    {
        $this->post['bankName'] = 'itau';
    }

    public function setBankBanrisul()
    {
        $this->post['bankName'] = 'banrisul';
    }

    public function setBankBancodoBrasil()
    {
        $this->post['bankName'] = 'bancodobrasil';
    }

    public function setBankBradesco()
    {
        $this->post['bankName'] = 'bradesco';
    }

    public function setBankHsbc()
    {
        $this->post['bankName'] = 'hsbc';
    }
}