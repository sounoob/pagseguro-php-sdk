<?php
include_once "core/PagSeguro.php";
include_once "core/Utils.php";

class SearchTransaction extends PagSeguro
{
    private $seguiment = array(
        'v2' => 'v2/transactions/',
        'v3' => 'v3/transactions/',
    );
    private $version = 'v3';
    public $result = false;
    private $filter = array();

    public function __construct($version = 'v3')
    {
        parent::__construct();
        $this->setVersion($version);
    }

    public function setReference($data)
    {
        $this->get['reference'] = $data;
    }

    public function setFinalDate($data)
    {
        $this->get['finalDate'] = $data;
    }
    public function setInitialDate($data)
    {
        $this->get['initialDate'] = $data;
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
        $this->url = $this->seguiment[$this->version];
        return parent::send();
    }
}