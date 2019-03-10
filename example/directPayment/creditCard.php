
<?php
include '../../vendor/autoload.php';
//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$payment = new \Sounoob\pagseguro\directPayment\CreditCard();
$payment->setSenderName('João comprador');
$payment->setSenderEmail('boonuos@sandbox.pagseguro.com.br');
$payment->setSenderPhone(11, 989015151);
$payment->setSenderCPF('01234567890');

$payment->addItem('1', 'Samsung S10+', 1, '0.22');
$payment->addItem('2', 'Galaxy Note 10', 1, '2.01');
$payment->addItem('3', 'iPhone XS', 1, '29387.35');
$payment->addItem('9', 'Pelicula iPhone', 5, '110.08');
$payment->setSenderHash('senderHashGeradoPelaLibJs');

$payment->setCreditCardToken('creditCardTokenGeradoPelaLibJs');


$payment->setHolderName('João comprador');
$payment->setHolderCPF('01234567890');
$payment->setHolderPhone(11, 989015151);
$payment->setHolderBirthDate('12/03/1990');

$payment->setBillingAddress('Rua guarantã', 23, 'Casa dos fundos');
$payment->setBillingAddressPostalCode('09976290');
$payment->setBillingDistrict('Eldorado');
$payment->setBillingAddressCity('Diadema');
$payment->setBillingAddressState('SP');
$payment->setBillingAddressCountry('BRA');

//Determina em quantas parcelas será dividido, e em quantas será sem juros, e qual bandeira do cartão.
$payment->setInstallment(1, 20, 'visa');



$result = $payment->send();
print_r($payment);