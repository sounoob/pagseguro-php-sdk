<?php
include '../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$transactions = new \Sounoob\pagseguro\SearchTransaction();
//Data inicial padrão 2017-10-15T19:11
$transactions->setInitialDate(date("Y-m-d\TH:i", strtotime("-30 days", time())));//Opcional caso passe a referência
//Data final padrão 2017-11-15T19:11
$transactions->setFinalDate(date("Y-m-d\TH:i", strtotime("now", time())));//Opcional
//Referência
$transactions->setReference('boonuos');//Opcional caso passe o initialDate
//Executa a conexão e captura a resposta do PagSeguro.
$transactions->send();

print_r($transactions);
exit;