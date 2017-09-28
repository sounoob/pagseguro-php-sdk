<?php
include '../source/Boleto.php';

$boleto = new Boleto();
$boleto->setReference('Referencia');
$boleto->setFirstDueDate('2017-09-29');
$boleto->setNumberOfPayments(12);
$boleto->setAmount('17.50');
$boleto->setInstructions('Juros de 1% ao dia e mora de 5,00');
$boleto->setDescription('Assinatura de sorvete');
$boleto->setCustomerCPF('01234567890');
$boleto->setCustomerName('Noob Master');
$boleto->setCustomerEmail('conato@contato.com.br');
$boleto->setCustomerPhone('11','98909084');
$boleto->setCustomerAddressPostalCode('01230000');
$boleto->setCustomerAddressStreet('Av Faria lima');
$boleto->setCustomerAddressNumber('103 A');
$boleto->setCustomerAddressDistrict('Vila Olimpia');
$boleto->setCustomerAddressCity('São Paulo');
$boleto->setCustomerAddressState('SP');

$data = $boleto->send();
print_r($data);exit;