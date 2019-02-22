<?php
namespace Sounoob\pagseguro\subscription;

use Sounoob\pagseguro\core\PagSeguro;

class EditPlan extends PagSeguro
{
    private $planCode = null;

    public function __construct($planCode)
    {
        parent::__construct();

        $this->planCode = $planCode;
    }

    public function setAmountPerPayment($amountPerPayment, $updateSubscriptions = false)
    {
        $this->post['amountPerPayment'] = $amountPerPayment;
        if($updateSubscriptions) {
            $this->post['updateSubscriptions'] = $updateSubscriptions;
        }
    }

    protected function requiredFields()
    {
        if(!isset($this->post['amountPerPayment'])) {
            //Prevents "Internal Server Error"
            throw new \Exception('amountPerPayment is required');
        }
    }
    
    public function send()
    {
        $this->url = 'pre-approvals/request/' . $this->planCode . '/payment';
        $this->curl->setCustomRequest('PUT');
        $this->curl->setContentType('application/json;charset=UTF-8');
        $this->curl->setAccept('application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1');
        parent::send();
    }
}