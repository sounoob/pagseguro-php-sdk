<?php
namespace Sounoob\pagseguro;

use Sounoob\pagseguro\core\PagSeguro;
use InvalidArgumentException;

class TransactionDetails extends PagSeguro
{
    private $code = null;
    private $seguiment = array(
        'v2' => 'v2/transactions/',
        'v3' => 'v3/transactions/',
    );
    private $version = 'v3';
    public $result = false;

    public function __construct($code, $version = 'v3')
    {
        parent::__construct();

        $this->code = $code;
        if (strlen($this->code) !== 32 && strlen($this->code) !== 36) {
            //PagSeguro error code 13003
            throw new InvalidArgumentException('invalid transactionCode value: ' . $this->code);
        }
        $this->setVersion($version);
        $this->result = $this->send();
    }

    public function setVersion($version)
    {
        if (!isset($this->seguiment[$version])) {
            throw new InvalidArgumentException('invalid API version: ' . $this->version);
        }
        $this->version = $version;
    }

    public function send()
    {
        $this->url = $this->seguiment[$this->version] . $this->code;
        return parent::send();
    }
}
