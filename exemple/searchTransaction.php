<?php
include '../source/SearchTransaction.php';

//Config::setProduction();
//Config::setSandbox();
//Config::setAccountCredentials('dev@sounoob.com.br', '5179DCD806314BD6A77B774DF6148CA9', true);

$transactions = new SearchTransaction();
//Data inicial padrão 2017-10-15T19:11
$transactions->setInitialDate(date("Y-m-d\TH:i", strtotime("-30 days", time())));//Opcional caso passe a referência
//Data final padrão 2017-11-15T19:11
$transactions->setFinalDate(date("Y-m-d\TH:i", strtotime("now", time())));//Opcional
//Referência
$transactions->setReference('Referencia Qualquer');//Opcional caso passe o initialDate
//Executa a conexão e captura a resposta do PagSeguro.
$transactions->send();

print_r($transactions);
exit;