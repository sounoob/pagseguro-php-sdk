
<?php
include '../../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$boleto = new \Sounoob\pagseguro\directPayment\Boleto();
$boleto->setSenderName('João comprador');
$boleto->setSenderEmail('contato@contato.com.br');
$boleto->setSenderPhone(11, 989015151);
$boleto->setSenderCPF('01234567890');

$boleto->addItem('1', 'Samsung S10+', 1, '0.22');
$boleto->addItem('2', 'Galaxy Note 10', 1, '2.01');
$boleto->addItem('3', 'iPhone XS', 1, '29387.35');
$boleto->setSenderHash('senderHashGeradoPelaLibJs');


$result = $boleto->send();
print_r($result);