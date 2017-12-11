<?php
class Curl
{
    private $header = array();
    private $data = array();
    private $curl = null;
    private $url = null;
    private $customRequest = 'POST';

    /**
     * Curl constructor.
     * @param array $header
     * @param array $data
     */
    public function __construct($url = null, array $data = array(), array $header = array())
    {
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

    public function setUrl($url)
    {
        if($this->url !== null) {
            throw new Exception('Cant rewrite url!');
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

    public function getData()
    {
        return $this->data;
    }

    public function setContentType($data)
    {
        $this->header[] = 'Content-type:' . $data;
    }

    public function setAccept($data)
    {
        $this->header[] = 'Accept:' . $data;
    }

    /**
     * @param array $data
     */
    public function setData($data, $format = 'x-www-form-urlencoded')
    {
        if($format == 'json') {
            $data = json_encode($data);
        }else{
            $data = http_build_query($data);
        }
        /*
         * @todo implement GET method
         * @todo Test as send twice
         * @todo implement XML
         */
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
        $this->data = $data;
    }

    public function parse_header()
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->header);
    }

    public function exec()
    {
        $this->parse_header();

        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $this->customRequest);

        if($this->customRequest == 'POST') {
            curl_setopt($this->curl, CURLOPT_POST, true);
        }


        $data = curl_exec($this->curl);
        $error = curl_error($this->curl);
        /*
         * @todo log this var $error
         */

        if($error) {
            $return = false;
        } elseif (strlen($data) === 0 || $data == 'Unauthorized') {
            throw new Exception('E-mail or token is invalid in this envolviment: ' . (Conf::isSandbox() ? 'Sandobx' : 'Production'));
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
     * @throws Exception
     */
    public function setCustomRequest($customRequest)
    {
        if(!in_array($customRequest, array(
            'GET',
            'PUT',
            'POST',
        ))) {
            throw new Exception('Request not available!');
        }
        $this->customRequest = $customRequest;
    }
}
