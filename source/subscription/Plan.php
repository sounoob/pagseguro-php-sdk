<?php
namespace Sounoob\pagseguro\subscription;

use Sounoob\pagseguro\core\PagSeguro;

class Plan extends PagSeguro
{
    public function setReceiverEmail($data)
    {
        $this->post['preApproval']['receiver']['email'] = $data;
    }
    public function setReviewURL($data)
    {
        $this->post['reviewURL'] = $data;
    }
    public function setMaxUses($data)
    {
        $this->post['maxUses'] = $data;
    }
    public function setRedirectURL($data)
    {
        $this->post['redirectURL'] = $data;
    }
    public function setReference($data)
    {
        $this->post['reference'] = $data;
    }
    public function setName($data)
    {
        $this->post['preApproval']['name'] = $data;
    }
    public function setChargeManual()
    {
        $this->post['preApproval']['charge'] = 'MANUAL';
    }
    public function setChargeAuto()
    {
        $this->post['preApproval']['charge'] = 'AUTO';
    }
    public function setAmountPerPayment($data)
    {
        if ($data < 1 || $data > 1000000) {
            //PagSeguro error code 11064
            throw new \InvalidArgumentException('preApprovalAmountPerPayment out of range: ' . $data);
        }
        $this->post['preApproval']['amountPerPayment'] = $data;
    }
    public function setTrialPeriodDuration($data)
    {
        $data = \Sounoob\pagseguro\core\Utils::onlyNumbers($data);
        
        if ($data <= 0 || $data > 1000000) {
            //PagSeguro error code 11058
            throw new \InvalidArgumentException('Trial period duration is invalid.');
        }
        $this->post['preApproval']['trialPeriodDuration'] = $data;
    }
    public function setDetails($data)
    {
        if (strlen($data) > 255) {
            //PagSeguro error code 11064
            throw new \InvalidArgumentException('preApprovalDetails invalid length: ' . $data);
        }
        $this->post['preApproval']['details'] = $data;
    }
    public function setMembershipFee($data)
    {
        if ($data <= 0 || $data > 1000000) {
            //PagSeguro error code 17076
            throw new \InvalidArgumentException('Membership fee is invalid.');
        }
        $this->post['preApproval']['membershipFee'] = $data;
    }
    public function setMaxAmountPerPeriod($data)
    {
        $this->post['preApproval']['maxAmountPerPeriod'] = $data;
    }    
    public function setMaxAmountPerPayment($data)
    {
        $this->post['preApproval']['maxAmountPerPayment'] = $data;
    }
    public function setMaxTotalAmount($data)
    {
        $this->post['preApproval']['maxTotalAmount'] = $data;
    }
    public function setMaxPaymentsPerPeriod($data)
    {
        $this->post['preApproval']['maxPaymentsPerPeriod'] = $data;
    }
    public function setInitialDate($data)
    {
        $this->post['preApproval']['initialDate'] = $data;
    }
    public function setFinalDate($data)
    {
        $this->post['preApproval']['finalDate'] = $data;
    }
    public function setDayOfYear($data)
    {
        $this->post['preApproval']['dayOfYear'] = $data;
    }
    public function setDayOfMonth($data)
    {
        $this->post['preApproval']['dayOfMonth'] = $data;
    }
    public function setDayOfWeek($data)
    {
        $this->post['preApproval']['dayOfWeek'] = $data;
    }
    public function setCancelURL($data)
    {
        $this->post['preApproval']['cancelURL'] = $data;
    }
    public function setPeriodWeekly()
    {
        $this->post['preApproval']['period'] = 'WEEKLY';
    }
    public function setPeriodMonthly()
    {
        $this->post['preApproval']['period'] = 'MONTHLY';
    }
    public function setPeriodBimonthly()
    {
        $this->post['preApproval']['period'] = 'BIMONTHLY';
    }
    public function setPeriodTrimonthly()
    {
        $this->post['preApproval']['period'] = 'TRIMONTHLY';
    }
    public function setPeriodSemiannually()
    {
        $this->post['preApproval']['period'] = 'SEMIANNUALLY';
    }
    public function setPeriodYearly()
    {
        $this->post['preApproval']['period'] = 'YEARLY';
    }
    public function setExpiration($unit, $value)
    {
        if(!in_array($unit, array(
            'YEARS',
            'MONTHS',
            'DAYS',
        ))) {
            //PagSeguro error code 17098
            throw new \Exception('expiration.unit invalid value: ' . $value);
        }
        if ($value < 1 || $value > 999) {
            //PagSeguro error code 17097
            throw new \InvalidArgumentException('expiration.value out of range: ' . $value . '. Value must be between 1 and 999');
        }
        $this->post['preApproval']['expiration']['unit'] = $unit;
        $this->post['preApproval']['expiration']['value'] = $value;
    }
    
    protected function requiredFields()
    {   
        if(!isset($this->post['preApproval']['charge']) || $this->post['preApproval']['charge'] == 'AUTO') {
            
            if (!isset($this->post['preApproval']['amountPerPayment']) || !isset($this->post['preApproval']['period'])) {
                //PagSeguro error code 11110
                throw new \Exception('in preApproval auto charged the following parameters are required: amountPerPayment and period');
            }
        }
    }
    
    protected function requiredFieldsButNot()
    {
        if (!isset($this->post['preApproval']['charge'])) {
            $this->post['preApproval']['charge'] = 'AUTO';
        }
        if (!isset($this->post['preApproval']['name'])) {
            $this->post['preApproval']['name'] = $this->post['preApproval']['charge'] . ' - ' . ($this->post['preApproval']['period'] ? $this->post['preApproval']['period'] : NULL);
        }
    }
    
    public function send()
    {
        $this->url = 'pre-approvals/request';
        $this->curl->setContentType('application/json;charset=ISO-8859-1');
        $this->curl->setAccept('application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1');
        parent::send();
        
        $this->link = isset($this->result->code) ? \Sounoob\pagseguro\config\Url::getPage() . 'pre-approvals/request.html?code=' . $this->result->code : null;
    }
}