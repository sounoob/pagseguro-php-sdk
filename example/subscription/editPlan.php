<?php
include '../../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$editPlan = new \Sounoob\pagseguro\subscription\EditPlan('F8A4A4799B9B7FCEE42C0FBBBEB0FBA2');
$editPlan->setAmountPerPayment('1.23', true);

$editPlan->send();

print_r($editPlan);
