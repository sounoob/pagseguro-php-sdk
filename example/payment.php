<?php
include '../source/Payment.php';

//Config::setProduction();
Config::setSandbox();
//Config::setAccountCredentials('dev@sounoob.com.br', '5179DCD806314BD6A77B774DF6148CA9', true);

$payment = new Payment();
$itens = array();
$itens[] = array(
    'id' => '0001',
    'description' => 'Notebook prata',
    'quantity' => 2,
    'amount' => '130.00',
);
$itens[] = array(
    'id' => '0002',
    'description' => 'Notebook preto',
    'quantity' => 2,
    'amount' => '430.00',
);
$itens[] = array(
    'id' => '0003',
    'description' => 'Notebook rosa',
    'quantity' => 4,
    'amount' => '330.00',
    'shippingCost' => '0.99',
);
$payment->addItens($itens);

$item4 = array();
$item4['id'] = 0004;
$item4['description'] = 'Notebook azul';
$item4['quantity'] = '8';
$item4['amount'] = '150.00';
$item4['weight'] = '200';
$item4['shippingCost'] = '1.00';

$payment->addItem(
    $item4['id'],
    $item4['description'],
    $item4['quantity'],
    $item4['amount'],
    $item4['weight'],
    $item4['shippingCost']
);
//$payment->skipAddress();

$payment->setShippingAddressState('SP');

$payment->setShippingTypeSedex();
//$payment->setShippingTypeOther();
//$payment->setShippingTypePAC();

$payment->send();
print_r($payment);exit;