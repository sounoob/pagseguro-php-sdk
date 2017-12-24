<?php
include '../source/Boleto.php';

//Config::setProduction();
//Config::setSandbox();
//Config::setAccountCredentials('dev@sounoob.com.br', '497226512D9D415F95AAC791F72778DE', false);


$boleto = new Boleto();
/*
 * Campos obrigatórios
 */
//Valor de cada boleto. Caso sua conta não absorver a taxa do boleto, será acrescentado 1 real no valor do boleto.
$boleto->setAmount('5.12');
//Descrição do boleto
$boleto->setDescription('Assinatura SDK SNoob');
//O CPF do comprador
$boleto->setCustomerCPF('01234567890');
//Nome do comprador
$boleto->setCustomerName('Noob Master');
//Email do comprador
$boleto->setCustomerEmail('financeiro@sounoob.com.br');
//Telefone do comprador
$boleto->setCustomerPhone('11','98909084');


/*
 * Campos opcionais
 */
//Data de vencimento do boleto no formato de Ano-Mês-Dia. Essa data precisa ser no futuro, e no máximo 30 dias apatir do dia atual.
$boleto->setFirstDueDate(date("Y-m-d", strtotime("+3 days", time())));
//Esse é o numero de boletos a ser gerado.
$boleto->setNumberOfPayments(1);
//Uma referência de quem é o boleto (note que terá multiplos boletos com a mesma referência)
$boleto->setReference('Referencia Qualquer');//**
//Instruções para quem irá receber o pagamento
$boleto->setInstructions('Aloprar o comprador se ele tentar pagar atrasado');
//CEP do comprador
$boleto->setCustomerAddressPostalCode('01230000');
//Endereço do comprador
$boleto->setCustomerAddressStreet('Av Faria lima');
//Numero da casa do comprador
$boleto->setCustomerAddressNumber('103 A');
//Bairro do comprador
$boleto->setCustomerAddressDistrict('Vila Olimpia');
//Cidade do comprador
$boleto->setCustomerAddressCity('São Paulo');
//Estado do comprador
$boleto->setCustomerAddressState('SP');


//Executa a conexão e captura a resposta do PagSeguro.
$data = $boleto->send();
print_r($data);exit;
