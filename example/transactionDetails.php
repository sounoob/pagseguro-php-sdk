<?php
include '../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$transactionV3 = new \Sounoob\pagseguro\TransactionDetails('07EAFAD5-B361-4DC7-BD9A-E01E0AED5F7C', 'v3');
$transactionV2 = new \Sounoob\pagseguro\TransactionDetails('07EAFAD5-B361-4DC7-BD9A-E01E0AED5F7C', 'v2');

print_r($transactionV3);
print_r($transactionV2);
exit;
