<?php
class PaymentTest extends \PHPUnit\Framework\TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        \Sounoob\pagseguro\config\Config::setProduction();
    }


    public function testPhone()
    {
        $payment = new \Sounoob\pagseguro\Payment();

        $payment->setSenderPhone(11, 9890151514);

        $data = $payment->build();

        $this->assertEquals('11', $data['senderAreaCode']);
        $this->assertEquals('989015151', $data['senderPhone']);
    }

    public function testCPF()
    {
        $payment = new \Sounoob\pagseguro\Payment();

        $payment->setSenderCPF('012.345.678-90');

        $data = $payment->build();

        $this->assertEquals('01234567890', $data['senderCPF']);
    }

    public function testItem()
    {
        $payment = new \Sounoob\pagseguro\Payment();
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
        $data = $payment->build();

        $this->assertEquals($itens[0]['id'], $data['itemId1']);
        $this->assertEquals($itens[0]['description'], $data['itemDescription1']);
        $this->assertEquals($itens[0]['quantity'], $data['itemQuantity1']);
        $this->assertEquals($itens[0]['amount'], $data['itemAmount1']);
        $this->assertEquals(false, isset($data['itemShippingCost1']));
        $this->assertEquals(false, isset($data['itemWeight1']));

        $this->assertEquals($itens[1]['id'], $data['itemId2']);
        $this->assertEquals($itens[1]['description'], $data['itemDescription2']);
        $this->assertEquals($itens[1]['quantity'], $data['itemQuantity2']);
        $this->assertEquals($itens[1]['amount'], $data['itemAmount2']);
        $this->assertEquals(false, isset($data['itemShippingCost2']));
        $this->assertEquals(false, isset($data['itemWeight2']));

        $this->assertEquals($itens[2]['id'], $data['itemId3']);
        $this->assertEquals($itens[2]['description'], $data['itemDescription3']);
        $this->assertEquals($itens[2]['quantity'], $data['itemQuantity3']);
        $this->assertEquals($itens[2]['amount'], $data['itemAmount3']);
        $this->assertEquals($itens[2]['shippingCost'], $data['itemShippingCost3']);
        $this->assertEquals(false, isset($data['itemWeight3']));

        $this->assertEquals($item4['id'], $data['itemId4']);
        $this->assertEquals($item4['description'], $data['itemDescription4']);
        $this->assertEquals($item4['quantity'], $data['itemQuantity4']);
        $this->assertEquals($item4['amount'], $data['itemAmount4']);
        $this->assertEquals($item4['shippingCost'], $data['itemShippingCost4']);
        $this->assertEquals($item4['weight'], $data['itemWeight4']);
    }
}
