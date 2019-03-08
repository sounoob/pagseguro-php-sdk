
<?php
include '../../vendor/autoload.php';
//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$payment = new \Sounoob\pagseguro\directPayment\Eft();
$payment->setSenderName('João comprador');
$payment->setSenderEmail('boonuos@sandbox.pagseguro.com.br');
$payment->setSenderPhone(11, 989015151);
$payment->setSenderCPF('01234567890');

$payment->addItem('1', 'Samsung S10+', 1, '0.22');
$payment->addItem('2', 'Galaxy Note 10', 1, '2.01');
$payment->addItem('3', 'iPhone XS', 1, '29387.35');
$payment->setSenderHash('senderHashGeradoPelaLibJs');

$payment->setBankItau();



$result = $payment->send();
print_r($result);