<?php

namespace Sounoob\pagseguro\subscription;

use Sounoob\pagseguro\core\PagSeguro;

/**
 * Class EditPlan
 * @package Sounoob\pagseguro\subscription
 */
class EditPlan extends PagSeguro
{
    /**
     * @var string
     */
    private $planCode = '';

    /**
     * EditPlan constructor.
     * @param $planCode
     * @throws \Exception
     */
    public function __construct($planCode)
    {
        parent::__construct();

        $this->planCode = $planCode;
    }

    /**
     * @param string $amountPerPayment
     * @param bool $updateSubscriptions
     */
    public function setAmountPerPayment($amountPerPayment, $updateSubscriptions = false)
    {
        $this->post['amountPerPayment'] = $amountPerPayment;
        if ($updateSubscriptions) {
            $this->post['updateSubscriptions'] = $updateSubscriptions;
        }
    }

    /**
     * @throws \Exception
     */
    protected function requiredFields()
    {
        if (!isset($this->post['amountPerPayment'])) {
            //Prevents "Internal Server Error"
            throw new \Exception('amountPerPayment is required');
        }
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->url = 'pre-approvals/request/' . $this->planCode . '/payment';
        $this->curl->setCustomRequest('PUT');
        $this->curl->setContentType('application/json;charset=UTF-8');
        $this->curl->setAccept('application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1');
        return parent::send();
    }
}