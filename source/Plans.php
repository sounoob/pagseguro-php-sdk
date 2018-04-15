<?php
include_once "core/PagSeguro.php";
include_once "core/Utils.php";
class Plans extends PagSeguro
{
    private $data = array();
    public $redirecURL = null;
    public $reviewURL = null;
    public $planName = null;
    public $planCharge = "AUTO";
    public $planPeriod = "MONTHLY";
    public $planAmountPerPayment = null;
    public $planMembershipFee = null;
    public $planTrialPeriodDuration = null;
    public $planExpirationValue = null;
    public $planExpirationUnit = "MONTHS";
    public $planDetails = null;
    public $planMaxAmountPerPeriod = null;
    public $planMaxAmountPerPayment = null;
    public $planDayOfWeek = null;
    public $planDayOfMonth = null;
    public $planDayOfYear = null;
    public $planFinalDate = null;
    public $planInitialDate = null;
    public $planMaxPaymentsPerPeriod = null;
    public $planMaxTotalAmount = null;
    public $cancelURL = null;
    public $maxUses = null;
    public function __construct()
    {
        parent::__construct();

        $this->post['currency'] = 'BRL';
        $this->post['shippingAddressRequired'] = 'true';
        $this->post['receiverEmail'] = Config::getEmail();
        $this->post['reference'] = 'generated automatically in: ' . date('r');
    }

    public function generate()
    {
        $this->setData(array(
            'redirectURL' => $this->post['redirectURL'],
            'reference' => $this->post['reference'],
            'preApproval' => array(
                'name' => $this->post['planName'],
                'charge' => $this->post['planCharge'],
                'period' => $this->post['planPeriod'],
                'amountPerPayment' => $this->post['amountPerPayment'],
                'membershipFee' => $this->post['membershipFee'],
                'trialPeriodDuration' => $this->post['planTrialPeriodDuration'],
                'expiration' => array(
                    'value' => $this->post['planExpirationValue'],
                    'unit' => $this->post['planExpirationUnit']
                ),
                'details' => $this->post['planDetails'],
                'maxAmountPerPeriod' => $this->post['planMaxAmountPerPeriod'],
                'maxAmountPerPayment' => $this->post['planMaxAmountPerPayment'],
                'maxTotalAmount' => $this->post['planMaxTotalAmount'],
                'maxPaymentsPerPeriod' => $this->post['planMaxPaymentsPerPeriod'],
                'initialDate' => $this->post['planInitialDate'],
                'finalDate' => $this->post['planFinalDate'],
                'dayOfYear' => $this->post['planDayOfYear'],
                'dayOfMonth' => $this->post['planDayOfMonth'],
                'dayOfWeek' => $this->post['planDayOfWeek'],
                'cancelURL' => $this->post['cancelURL']
            ),
            'reviewURL' => $this->post['reviewURL'],
            'maxUses' => $this->post['maxUses'],
            'receiver' => array(
                'email' => $this->post['receiverEmail']
            )
        ));
    }

    public function setPlanAmountPerPayment($planAmountPerPayment)
    {
        $this->post['planAmountPerPayment'] = $planAmountPerPayment;
    }

    public function setPlanMembershipFee($planMembershipFee)
    {
        $this->post['planMembershipFee'] = $planMembershipFee;
    }

    public function setPlanTrialPeriodDuration($planTrialPeriodDuration)
    {
        $this->post['planTrialPeriodDuration']= $planTrialPeriodDuration;
    }

    public function setPlanExpirationValue($planExpirationValue)
    {
        $this->post['planExpirationValue'] = $planExpirationValue;
    }

    public function setPlanExpirationUnit($planExpirationUnit)
    {
        $this->post['planExpirationUnit'] = $planExpirationUnit;
    }

    public function setPlanDetails($planDetails)
    {
        $this->post['planDetails'] = $planDetails;
    }

    public function setPlanMaxAmountPerPeriod($planMaxAmountPerPeriod)
    {
        $this->post['planMaxAmountPerPeriod'] = $planMaxAmountPerPeriod;
    }

    public function setPlanMaxAmountPerPayment($planMaxAmountPerPayment)
    {
        $this->post['planMaxAmountPerPayment'] = $planMaxAmountPerPayment;
    }

    public function setPlanDayOfWeek($planDayOfWeek)
    {
        $this->post['planDayOfWeek'] = $planDayOfWeek;
    }

    public function setPlanDayOfMonth($planDayOfMonth)
    {
        $this->post['planDayOfMonth'] = $planDayOfMonth;
    }

    public function setPlanDayOfYear($planDayOfYear)
    {

        $this->post['planDayOfYear'] = $planDayOfYear;
    }

    public function setPlanFinalDate($planFinalDate)
    {
        $this->post['planFinalDate'] = $planFinalDate;
    }

    public function setPlanInitialDate($planInitialDate)
    {
        $this->post['planInitialDate'] = $planInitialDate;
    }

    public function setPlanMaxPaymentsPerPeriod($planMaxPaymentsPerPeriod)
    {
        $this->post['planMaxPaymentsPerPeriod'] = $planMaxPaymentsPerPeriod;
    }

    public function setPlanMaxTotalAmount($planMaxTotalAmount)
    {
        $this->post['planMaxTotalAmount']= $planMaxTotalAmount;
    }

    public function setCancelURL($cancelURL)
    {
        $this->post['cancelURL'] = $cancelURL;
    }

    public function setPlanCharge($planCharge)
    {
        $this->post['planCharge'] = $planCharge;
    }


    public function setPlanPeriod($planPeriod)
    {
        $this->post['planPeriod'] = $planPeriod;
    }

    public function setMaxUses($maxUses)
    {
        $this->post['maxUses'] = $maxUses;
    }

    public function setPlanName($planName)
    {
        $this->post['planName'] = $planName;
    }

    public function setReviewURL($reviewURL)
    {
        $this->post['reviewURL'] = $reviewURL;
    }

    public function setRedirecURL($redirecURL)
    {
        $this->post['redirectURL'] = $redirecURL;
    }

    public function setData($data)
    {
        $this->data = $data;
    }


}