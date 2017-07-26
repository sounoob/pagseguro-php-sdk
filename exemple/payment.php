<?php
include '../source/Payment.php';

$payment = new Payment();

$iten[] = array(
    'id' =>'0001',
    'description' => 'Notebook prata',
    'quantity' => 2,
    'amount' => '130.00'
);

$iten[] = array(
    'id' =>'0002',
    'description' => 'Notebook preto',
    'quantity' => 2,
    'amount' => '430.00'
);
$payment->setShippingAddressState('SP');
$payment->additens($iten);

$payment->setShippingTypeSedex();

$data = $payment->redirectCode();

echo $data;