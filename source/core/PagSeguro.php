<?php
include_once dirname(__FILE__) . "/../config/Config.php";
include_once dirname(__FILE__) . "/../config/Url.php";
include_once "Curl.php";

class PagSeguro
{
    protected $post = array();
    protected $url = null;
    protected $curl = null;
    protected $get = array();
    public $result = false;

    public function __construct()
    {
        $this->curl = new Curl();
    }


    protected function requiredFields()
    {

    }

    protected function requiredFieldsButNot()
    {

    }

    private function buildURL()
    {
        $this->get['email'] = Config::getEmail();
        $this->get['token'] = Config::getToken();

        $this->url = URL::getWs() . $this->url . '?' . http_build_query($this->get);

        $this->curl->setUrl($this->url);
    }

    public function build()
    {
        $this->requiredFields();
        $this->requiredFieldsButNot();
        $this->buildURL();
    }
    public function send()
    {
        $this->build();
        if(count($this->post)) {
            $this->curl->setData($this->post);
        }

        return $this->result = $this->curl->exec();
    }
}
