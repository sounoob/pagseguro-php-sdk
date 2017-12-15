<?php
include '../source/SearchTransaction.php';

//Conf::setProduction();
//Conf::setSandbox();
//Conf::setAccountCredentials('dev@sounoob.com.br', '497226512D9D415F95AAC791F72778DE', true);

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