<?php
include '../../vendor/autoload.php';

\Sounoob\pagseguro\config\Config::setAccountCredentials('japle_noodles@hotmail.com', 'F6AEBAA77FF343A4ACA390E76C335511');

$editPlan = new \Sounoob\pagseguro\subscription\EditPlan('F8A4A4799B9B7FCEE42C0FBBBEB0FBA2');
$editPlan->setAmountPerPayment('1.23', true);

$editPlan->send();

print_r($editPlan);