<?php
include '../../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$accession = new \Sounoob\pagseguro\subscription\Accession();

/*
 * Campos obrigatórios
 */
//Código do plano
$accession->setPlan('F8A4A4799B9B7FCEE42C0FBBBEB0FBA2');
//Nome do comprador
$accession->setSenderName('Joãolucas');
//E-mail do comprador
$accession->setSenderEmail('jon@sandbox.pagseguro.com.br');
//Telefone do comprador
$accession->setSenderPhone(11, 989015151);
//CPF do comprador
$accession->setSenderCPF('012.345.678-90');
//Endereço do comprador
$accession->setSenderAddress('Rua guarantã', '13', 'Fundos');
//CEP do comprador
$accession->setSenderPostalCode('09976290');
//Cidade do comprador
$accession->setSenderCity('Diadema');
//Estado do comprador
$accession->setSenderState('sp');
//Bairro do comprador
$accession->setSenderDistrict('Eldorado');
//Data de aniversário do dono do cartão de crédito
$accession->setHolderBirthDate('12/03/1990');
//Sender hash gerado pela biblioteca javascript
$accession->setSenderHash('e7795de056faf6fed882baac64c6ac96735ee8e8c24a388ba070d862bbd25ab5');
//Token do cartão de crédito
$accession->setCreditCardToken('7311c36b3a8d416195826f941e90f2ac');

/*
 * Campos opcionais
 */


//Uma referência de quem é o boleto
$accession->setReference('boonuos');
//Nome do dono do cartão de crédito (se não for enviado o SDK vai assumir que é o mesmo do comprador)
$accession->setHolderName('Pedro Lucas');
//Telefone do dono do cartão de crédito (se não for enviado o SDK vai assumir que é o mesmo do comprador)
$accession->setHolderPhone(12, 915151890);
//CPF do dono do cartão de crédito (se não for enviado o SDK vai assumir que é o mesmo do comprador)
$accession->setHolderCPF('01234567890');

$accession->send();

print_r($accession);