<?php
include '../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setProduction();
//\Sounoob\pagseguro\config\Config::setSandbox();
//\Sounoob\pagseguro\config\Config::setAccountCredentials('dev@sounoob.com.br', '5179DCD806314BD6A77B774DF6148CA9', true);

$transactionV3 = new \Sounoob\pagseguro\TransactionDetails('07EAFAD5-B361-4DC7-BD9A-E01E0AED5F7C', 'v3');
$transactionV2 = new \Sounoob\pagseguro\TransactionDetails('07EAFAD5-B361-4DC7-BD9A-E01E0AED5F7C', 'v2');

print_r($transactionV3);
print_r($transactionV2);
exit;
