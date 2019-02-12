<?php
include '../../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$plan = new \Sounoob\pagseguro\subscription\Plan();
//Valor do plano
$plan->setAmountPerPayment('1000000.00');

//Periodo que será cobrado o valor do plano
$plan->setPeriodYearly();
$plan->setPeriodSemiannually();
$plan->setPeriodTrimonthly();
$plan->setPeriodBimonthly();
$plan->setPeriodMonthly();
$plan->setPeriodWeekly();

/*
 * Campos opcionais
 */
//Tipo de cobrança 
$plan->setChargeManual();
$plan->setChargeAuto();

//Nome do plano
$plan->setName('Assinatura');

//Expiração do plano
$plan->setExpiration('YEARS', 999);

//Taxa de adesão
$plan->setMembershipFee('0.01');

//Período de testes
$plan->setTrialPeriodDuration('1000000');

//Período de testes
$plan->setDetails('Isso é uma descrição opcional, mas recomendo muito usar para deixar bem claro para seu comprador, o que ele está aderindo.');

$plan->send();

print_r($plan);