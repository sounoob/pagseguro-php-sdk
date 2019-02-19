<?php
namespace Sounoob\pagseguro;

use Sounoob\pagseguro\core\PagSeguro;

class Session extends PagSeguro
{
    private $seguiment = array(
        'v1' => 'sessions/',
        'v2' => 'v2/sessions/',
    );
    private $version = null;
    
    public function __construct($version = 'v2')
    {
        parent::__construct();
        $this->setVersion($version);
        $this->curl->setCustomRequest('POST');
        $this->result = $this->send();
    }
    private function setVersion($version)
    {
        if (!isset($this->seguiment[$version])) {
            throw new \InvalidArgumentException('invalid API version: ' . $this->version);
        }
        $this->version = $version;
    }
    public function send()
    {
        $this->url = $this->seguiment[$this->version];
        return parent::send();
    }
}