<?php
include '../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$installments = new \Sounoob\pagseguro\Installments('100.00', 'Visa', 4);

print_r($installments);