<?php
include '../source/Payment.php';

//Conf::setProduction();
//Conf::setSandbox();
//Conf::setAccountCredentials('dev@sounoob.com.br', 'CEEE2C5274A149588A3A3F4211BE9C42', true);

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

$data = $payment->redirectCode();
print_r($data);exit;