<?php
include '../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setProduction();
//\Sounoob\pagseguro\config\Config::setSandbox();
//\Sounoob\pagseguro\config\Config::setAccountCredentials('dev@sounoob.com.br', '5179DCD806314BD6A77B774DF6148CA9', true);

$transactionV3 = new \Sounoob\pagseguro\NotificationTransaction('F91E2D-BB5C775C7753-59943C7FBD69-2B03C3', 'v3');
$transactionV2 = new \Sounoob\pagseguro\NotificationTransaction('F91E2DBB5C775C775359943C7FBD692B03C3', 'v2');

print_r($transactionV3);
print_r($transactionV2);
exit;
