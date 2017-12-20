<?php

include_once "Config.php";
include_once "Utils.php";
include_once "Curl.php";

class SearchTransaction
{
    private $url = array(
        'v2' => 'v2/transactions/',
        'v3' => 'v3/transactions/',
    );
    private $version = 'v3';
    public $result = false;
    private $filter = array();

    public function __construct($version = 'v3')
    {
        $this->setVersion($version);
    }

    public function setReference($data)
    {
        $this->filter['reference'] = $data;
    }

    public function setFinalDate($data)
    {
        $this->filter['finalDate'] = $data;
    }
    public function setInitialDate($data)
    {
        $this->filter['initialDate'] = $data;
    }

    public function setVersion($version)
    {
        if (!isset($this->url[$version])) {
            throw new InvalidArgumentException('invalid API version: ' . $this->version);
        }
        $this->version = $version;
    }

    public function send()
    {
        $url = URL::getWs() . $this->url[$this->version] . '/?email=' . Conf::getEmail() . '&token=' . Conf::getToken() . '&' . http_build_query($this->filter);

        $curl = new Curl($url);
        $curl->setCustomRequest('GET');
        return $this->result = $curl->exec();
    }
}
