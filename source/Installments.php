<?php

namespace Sounoob\pagseguro;

use Sounoob\pagseguro\config\Url;
use Sounoob\pagseguro\core\PagSeguro;

/**
 * Class Installments
 * @package Sounoob\pagseguro
 */
class Installments extends PagSeguro
{
    public function __construct($amount, $creditCardBrand = 'visa', $maxInstallmentNoInterest = 1)
    {
        parent::__construct();
        $this->get['session'] = new Session();
        $this->get['sessionId'] = current($this->get['session']->result->id);

        $this->get['amount'] = $amount;
        $this->get['creditCardBrand'] = strtolower($creditCardBrand);

        if($maxInstallmentNoInterest > 1) {
            $this->get['maxInstallmentNoInterest'] = $maxInstallmentNoInterest;
        }

        $this->result = $this->send();
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->url = Url::getPage() . 'checkout/v2/installments.json';
        return parent::send();
    }
}