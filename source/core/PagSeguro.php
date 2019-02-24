<?php

namespace Sounoob\pagseguro\core;

/**
 * Class PagSeguro
 * @package Sounoob\pagseguro\core
 */
class PagSeguro
{
    /**
     * @var array
     */
    protected $post = array();
    /**
     * @var string
     */
    protected $url = null;
    /**
     * @var Curl
     */
    protected $curl = null;
    /**
     * @var array
     */
    protected $get = array();
    /**
     * @var bool|\stdClass|SimpleXMLElement
     */
    public $result = false;

    /**
     * PagSeguro constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->curl = new Curl();
    }

    protected function requiredFields()
    {
    }

    protected function defaultValues()
    {
    }

    /**
     * @throws \Exception
     */
    private function buildURL()
    {
        $this->get['email'] = \Sounoob\pagseguro\config\Config::getEmail();
        $this->get['token'] = \Sounoob\pagseguro\config\Config::getToken();

        $this->url = \Sounoob\pagseguro\config\Url::getWs() . $this->url . '?' . http_build_query($this->get);

        $this->curl->setUrl($this->url);
    }

    /**
     * @throws \Exception
     */
    public function build()
    {
        $this->requiredFields();
        $this->defaultValues();
        $this->buildURL();
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function send()
    {
        $this->build();
        if (count($this->post)) {
            $this->curl->setData($this->post);
        }

        return $this->result = $this->curl->exec();
    }
}
