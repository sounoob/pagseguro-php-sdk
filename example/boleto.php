<?php
include '../vendor/autoload.php';

//\Sounoob\pagseguro\config\Config::setAccountCredentials('seu@email.com.br', 'BD65179DCD806314A77B774DF6148CA9');

$boleto = new \Sounoob\pagseguro\Boleto();
/*
 * Campos obrigatórios
 */
//Valor de cada boleto. Caso sua conta não absorver a taxa do boleto, será acrescentado 1 real no valor do boleto.
$boleto->setAmount('5.12');
//Descrição do boleto
$boleto->setDescription('Assinatura SDK SNoob');
//O CPF do comprador
$boleto->setCustomerCPF('01234567890');//Se for CNPJ use $boleto->setCustomerCNPJ('33085736000169');
//Nome do comprador
$boleto->setCustomerName('Noob Master');
//Email do comprador
$boleto->setCustomerEmail('email.comprador@sounoob.com.br');
//Telefone do comprador
$boleto->setCustomerPhone('11', '98909084');


/*
 * Campos opcionais
 */
//Data de vencimento do boleto no formato de Ano-Mês-Dia. Essa data precisa ser no futuro, e no máximo 30 dias apatir do dia atual.
$boleto->setFirstDueDate(date("Y-m-d", strtotime("+3 days", time())));
//Esse é o numero de boletos a ser gerado.
$boleto->setNumberOfPayments(2);
//Uma referência de quem é o boleto (note que terá multiplos boletos com a mesma referência)
$boleto->setReference('boonuos');//**
//Instruções para quem irá receber o pagamento
$boleto->setInstructions('Aloprar o comprador se ele tentar pagar atrasado');
//CEP do comprador
$boleto->setCustomerAddressPostalCode('01230000');
//Endereço do comprador
$boleto->setCustomerAddress('Av Faria lima', '103 A');
//Bairro do comprador
$boleto->setCustomerAddressDistrict('Vila Olimpia');
//Cidade do comprador
$boleto->setCustomerAddressCity('São Paulo');
//Estado do comprador
$boleto->setCustomerAddressState('SP');


//Executa a conexão e captura a resposta do PagSeguro.
$data = $boleto->send();

//Você terá uma array de objeto, precisará de uma estrutura de laço para percorrer um a um.
foreach ($data->boletos as $row) {
    echo 'A transação de código ' . $row->code .
        ' que vence em ' . $row->dueDate .
        ' gerou um boleto que pode ser acessado no link ' . $row->paymentLink .
        ' ou pago com o código de barras ' . $row->barcode .
        '<hr>';
}
