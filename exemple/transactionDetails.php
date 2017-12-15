<?php
include '../source/transactionDetails.php';

//Conf::setProduction();
//Conf::setSandbox();
//Conf::setAccountCredentials('dev@sounoob.com.br', '497226512D9D415F95AAC791F72778DE', true);

$transactionV3 = new TransactionDetails('07EAFAD5-B361-4DC7-BD9A-E01E0AED5F7C', 'v3');
$transactionV2 = new TransactionDetails('07EAFAD5-B361-4DC7-BD9A-E01E0AED5F7C', 'v2');

print_r($transactionV3);
print_r($transactionV2);
exit;
