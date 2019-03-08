<?php

namespace Sounoob\pagseguro\directPayment;

use Sounoob\pagseguro\directPayment\core\DirectPayment;

class Boleto extends DirectPayment
{
    protected function defaultValues()
    {
        if (!isset($this->post['paymentMethod'])) {
            $this->post['paymentMethod'] = 'boleto';
        }
        parent::defaultValues();
    }
}