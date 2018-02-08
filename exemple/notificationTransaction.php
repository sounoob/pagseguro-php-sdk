<?php
include '../source/NotificationTransaction.php';

//Config::setProduction();
//Config::setSandbox();
//Config::setAccountCredentials('dev@sounoob.com.br', '5179DCD806314BD6A77B774DF6148CA9', true);

$transactionV3 = new NotificationTransaction('F91E2D-BB5C775C7753-59943C7FBD69-2B03C3', 'v3');
$transactionV2 = new NotificationTransaction('F91E2DBB5C775C775359943C7FBD692B03C3', 'v2');

print_r($transactionV3);
print_r($transactionV2);
exit;
