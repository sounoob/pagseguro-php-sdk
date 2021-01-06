<?php
include '../../vendor/autoload.php';

\Sounoob\pagseguro\config\Config::setAccountCredentials('email@domain.com', 'AEBAA77FF343A4ACA390E76C335511F6');

$editPlan = new \Sounoob\pagseguro\subscription\EditPlan('F8A4A4799B9B7FCEE42C0FBBBEB0FBA2');
$editPlan->setAmountPerPayment('1.23', true);

$editPlan->send();

print_r($editPlan);
