<?php
namespace Sounoob\pagseguro;

use Sounoob\pagseguro\core\PagSeguro;

/**
 * Class NotificationTransaction
 * @package Sounoob\pagseguro
 */
class NotificationTransaction extends PagSeguro
{
    /**
     * @var string
     */
    private $code = '';
    /**
     * @var array
     */
    private $seguiment = array(
        'v2' => 'v2/transactions/notifications/',
        'v3' => 'v3/transactions/notifications/',
    );
    /**
     * @var string
     */
    private $version = 'v3';
    /**
     * @var bool|\SimpleXMLElement|\stdClass
     */
    public $result = false;

    /**
     * NotificationTransaction constructor.
     * @param string $code
     * @param string $version
     * @throws \Exception
     */
    public function __construct($code, $version = 'v3')
    {
        parent::__construct();

        $this->code = $code;
        if (strlen($this->code) !== 36 && strlen($this->code) !== 39) {
            //PagSeguro error code 13001
            throw new \InvalidArgumentException('invalid notification code value: ' . $this->code);
        }
        $this->setVersion($version);
        $this->result = $this->send();
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
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