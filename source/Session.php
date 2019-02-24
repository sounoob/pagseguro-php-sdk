<?php

namespace Sounoob\pagseguro;

use Sounoob\pagseguro\core\PagSeguro;

/**
 * Class Session
 * @package Sounoob\pagseguro
 */
class Session extends PagSeguro
{
    /**
     * @var array
     */
    private $seguiment = array(
        'v1' => 'sessions/',
        'v2' => 'v2/sessions/',
    );
    /**
     * @var string
     */
    private $version = '';

    /**
     * Session constructor.
     * @param string $version
     * @throws \Exception
     */
    public function __construct($version = 'v2')
    {
        parent::__construct();
        $this->setVersion($version);
        $this->curl->setCustomRequest('POST');
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
        $this->url = $this->seguiment[$this->version];
        return parent::send();
    }
}