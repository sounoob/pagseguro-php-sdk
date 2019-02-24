<?php

namespace Sounoob\pagseguro;

use Sounoob\pagseguro\core\PagSeguro;

/**
 * Class TransactionDetails
 * @package Sounoob\pagseguro
 */
class TransactionDetails extends PagSeguro
{
    /**
     * @var string
     */
    private $code = '';
    /**
     * @var array
     */
    private $seguiment = array(
        'v2' => 'v2/transactions/',
        'v3' => 'v3/transactions/',
    );
    /**
     * @var string
     */
    private $version = '';

    /**
     * TransactionDetails constructor.
     * @param $code
     * @param string $version
     * @throws \Exception
     */
    public function __construct($code, $version = 'v3')
    {
        parent::__construct();

        $this->code = $code;
        if (strlen($this->code) !== 32 && strlen($this->code) !== 36) {
            //PagSeguro error code 13003
            throw new \InvalidArgumentException('invalid transactionCode value: ' . $this->code);
        }
        $this->setVersion($version);
        $this->result = $this->send();
    }

    /**
     * @param string $version
     */
    private function setVersion($version)
    {
        if (!isset($this->seguiment[$version])) {
            throw new \InvalidArgumentException('invalid API version: ' . $this->version);
        }
        $this->version = $version;
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->url = $this->seguiment[$this->version] . $this->code;
        return parent::send();
    }
}
