<?php
namespace Sounoob\pagseguro\core;

/**
 * Class Curl
 * @package Sounoob\pagseguro\core
 */
class Curl
{
    /**
     * @var array
     */
    private $header = array();
    /**
     * @var resource
     */
    private $curl = null;
    /**
     * @var string
     */
    private $url = null;
    /**
     * @var string
     */
    private $customRequest = null;

    /**
     * Curl constructor.
     * @param null $url
     * @param array $data
     * @param array $header
     * @throws \Exception
     */
    public function __construct($url = null, array $data = array(), array $header = array())
    {
        if (!extension_loaded("curl")) {
            throw new \Exception("cURL extension is required!");
        }
        $this->curl = curl_init();

        if($url !== null) {
            $this->setUrl($url);
        }

        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        if (count($header) > 0) {
            $this->setHeader($header);
        }
        if (count($data) > 0) {
            $this->setData($data);
        }
    }

    /**
     * @param $url
     * @throws \Exception
     */
    public function setUrl($url)
    {
        if($this->url !== null) {
            throw new \Exception('Cant rewrite url!');
        }else{
            curl_setopt($this->curl, CURLOPT_URL, $url);
        }
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param array $header
     */
    public function setHeader($header)
    {
        $this->header[] = $header;
    }

    /**
     * @param $data
     */
    public function setContentType($data)
    {
        $this->header[] = 'Content-type:' . $data;
    }

    /**
     * @param $data
     */
    public function setAccept($data)
    {
        $this->header[] = 'Accept:' . $data;
    }

    /**
     * @return string
     */
    private function detectDataFormat()
    {
        $format = 'x-www-form-urlencoded';
        foreach ($this->header as $row) {
            if(strpos($row, 'Content-type') !== false) {
                if(strpos($row, 'json') !== false) {
                    $format = 'json';
                }elseif(strpos($row, 'xml') !== false) {
                    $format = 'xml';
                }
            }
        }
        return $format;
    }


    /**
     * @param $data
     * @throws \Exception
     */
    public function setData($data)
    {
        $format = $this->detectDataFormat();

        $data = $format == 'json' ? json_encode($data) : http_build_query($data);
        /*
         * @todo Test as send twice
         * @todo implement XML
         */
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $this->setCustomRequest($this->customRequest ? $this->customRequest : 'POST');
    }

    public function parse_header()
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header);
    }

    /**
     * @return \SimpleXMLElement|\stdClass
     * @throws \Exception
     */
    public function exec()
    {
        $this->parse_header();
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->customRequest);

        if($this->customRequest == 'POST') {
            curl_setopt($this->curl, CURLOPT_POST, true);
        }


        $data = utf8_encode(curl_exec($this->curl));
        $statusCode = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        $error = curl_error($this->curl);
        /*
         * @todo log this var $error
         */

        if($error) {
            $return = $error;
        } elseif ($statusCode == 401 || $data == 'Unauthorized') {
            throw new \Exception('E-mail or token is invalid in this environment: ' . (\Sounoob\pagseguro\config\Config::isSandbox() ? 'Sandobx' : 'Production'));
        } elseif (strlen($data) === 0) {
            //Empty body
            $return = $data;
        } elseif ($data{0} == '{') {
            $return = json_decode($data);
        } elseif (strpos($data, '<?xml') !== false) {
            $return = simplexml_load_string($data);
        } else {
            $return = $data;
        }
        return $return;
    }

    /**
     * @param string $customRequest
     * @throws \Exception
     */
    public function setCustomRequest($customRequest)
    {
        if(!in_array($customRequest, array(
            'GET',
            'PUT',
            'POST',
        ))) {
            throw new \Exception('Request not available!');
        }
        $this->customRequest = $customRequest;
    }
}
