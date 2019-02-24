<?php

namespace Sounoob\pagseguro\subscription;

use Sounoob\pagseguro\config\Url;
use Sounoob\pagseguro\core\PagSeguro;
use Sounoob\pagseguro\core\Utils;

/**
 * Class Plan
 * @package Sounoob\pagseguro\subscription
 */
class Plan extends PagSeguro
{
    /**
     * @param string $email
     */
    public function setReceiverEmail($email)
    {
        $this->post['preApproval']['receiver']['email'] = $email;
    }

    /**
     * @param string $url
     */
    public function setReviewURL($url)
    {
        $this->post['reviewURL'] = $url;
    }

    /**
     * @param string $maxUses
     */
    public function setMaxUses($maxUses)
    {
        $this->post['maxUses'] = $maxUses;
    }

    /**
     * @param string $url
     */
    public function setRedirectURL($url)
    {
        $this->post['redirectURL'] = $url;
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
    public function setName($name)
    {
        $this->post['preApproval']['name'] = $name;
    }

    public function setChargeManual()
    {
        $this->post['preApproval']['charge'] = 'MANUAL';
    }

    public function setChargeAuto()
    {
        $this->post['preApproval']['charge'] = 'AUTO';
    }

    /**
     * @param double $amountPerPayment
     */
    public function setAmountPerPayment($amountPerPayment)
    {
        if ($amountPerPayment < 1 || $amountPerPayment > 1000000) {
            //PagSeguro error code 11064
            throw new \InvalidArgumentException('preApprovalAmountPerPayment out of range: ' . $amountPerPayment);
        }
        $this->post['preApproval']['amountPerPayment'] = $amountPerPayment;
    }

    /**
     * @param int $trialPeriodDuration
     */
    public function setTrialPeriodDuration($trialPeriodDuration)
    {
        $trialPeriodDuration = Utils::onlyNumbers($trialPeriodDuration);

        if ($trialPeriodDuration <= 0 || $trialPeriodDuration > 1000000) {
            //PagSeguro error code 11058
            throw new \InvalidArgumentException('Trial period duration is invalid.');
        }
        $this->post['preApproval']['trialPeriodDuration'] = $trialPeriodDuration;
    }

    /**
     * @param string $details
     */
    public function setDetails($details)
    {
        if (strlen($details) > 255) {
            //PagSeguro error code 11064
            throw new \InvalidArgumentException('preApprovalDetails invalid length: ' . $details);
        }
        $this->post['preApproval']['details'] = $details;
    }

    /**
     * @param double $membershipFee
     */
    public function setMembershipFee($membershipFee)
    {
        if ($membershipFee <= 0 || $membershipFee > 1000000) {
            //PagSeguro error code 17076
            throw new \InvalidArgumentException('Membership fee is invalid.');
        }
        $this->post['preApproval']['membershipFee'] = $membershipFee;
    }

    /**
     * @param double $maxAmountPerPeriod
     */
    public function setMaxAmountPerPeriod($maxAmountPerPeriod)
    {
        $this->post['preApproval']['maxAmountPerPeriod'] = $maxAmountPerPeriod;
    }

    /**
     * @param double $maxAmountPerPayment
     */
    public function setMaxAmountPerPayment($maxAmountPerPayment)
    {
        $this->post['preApproval']['maxAmountPerPayment'] = $maxAmountPerPayment;
    }

    /**
     * @param double $maxTotalAmount
     */
    public function setMaxTotalAmount($maxTotalAmount)
    {
        $this->post['preApproval']['maxTotalAmount'] = $maxTotalAmount;
    }

    /**
     * @param double $maxPaymentsPerPeriod
     */
    public function setMaxPaymentsPerPeriod($maxPaymentsPerPeriod)
    {
        $this->post['preApproval']['maxPaymentsPerPeriod'] = $maxPaymentsPerPeriod;
    }

    /**
     * @param string $initialDate
     */
    public function setInitialDate($initialDate)
    {
        $this->post['preApproval']['initialDate'] = $initialDate;
    }

    /**
     * @param string $finalDate
     */
    public function setFinalDate($finalDate)
    {
        $this->post['preApproval']['finalDate'] = $finalDate;
    }

    /**
     * @param int $dayOfYear
     */
    public function setDayOfYear($dayOfYear)
    {
        $this->post['preApproval']['dayOfYear'] = $dayOfYear;
    }

    /**
     * @param int $dayOfMonth
     */
    public function setDayOfMonth($dayOfMonth)
    {
        $this->post['preApproval']['dayOfMonth'] = $dayOfMonth;
    }

    /**
     * @param int $dayOfWeek
     */
    public function setDayOfWeek($dayOfWeek)
    {
        $this->post['preApproval']['dayOfWeek'] = $dayOfWeek;
    }

    /**
     * @param string $url
     */
    public function setCancelURL($url)
    {
        $this->post['preApproval']['cancelURL'] = $url;
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

    /**
     * @param string $unit
     * @param int $value
     * @throws \Exception
     */
    public function setExpiration($unit, $value)
    {
        if (!in_array($unit, array(
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

    /**
     * @throws \Exception
     */
    protected function requiredFields()
    {
        if (!isset($this->post['preApproval']['charge']) || $this->post['preApproval']['charge'] == 'AUTO') {

            if (!isset($this->post['preApproval']['amountPerPayment']) || !isset($this->post['preApproval']['period'])) {
                //PagSeguro error code 11110
                throw new \Exception('in preApproval auto charged the following parameters are required: amountPerPayment and period');
            }
        }
    }

    protected function defaultValues()
    {
        if (!isset($this->post['preApproval']['charge'])) {
            $this->post['preApproval']['charge'] = 'AUTO';
        }
        if (!isset($this->post['preApproval']['name'])) {
            $this->post['preApproval']['name'] = $this->post['preApproval']['charge'] . ' - ' . ($this->post['preApproval']['period'] ? $this->post['preApproval']['period'] : NULL);
        }
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->url = 'pre-approvals/request';
        $this->curl->setContentType('application/json;charset=UTF-8');
        $this->curl->setAccept('application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1');
        parent::send();

        $this->link = isset($this->result->code) ? Url::getPage() . 'pre-approvals/request.html?code=' . $this->result->code : null;
    }
}