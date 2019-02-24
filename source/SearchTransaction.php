<?php
namespace Sounoob\pagseguro;

use Sounoob\pagseguro\core\PagSeguro;

/**
 * Class SearchTransaction
 * @package Sounoob\pagseguro
 */
class SearchTransaction extends PagSeguro
{
    /**
     * @var array
     */
    private $seguiment = array(
        'v2' => 'v2/transactions/',
        'v3' => 'v3/transactions/',
    );
    /**
     * @var string
     */
    private $version = '';

    /**
     * SearchTransaction constructor.
     * @param string $version
     * @throws \Exception
     */
    public function __construct($version = 'v3')
    {
        parent::__construct();
        $this->setVersion($version);
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->get['reference'] = $reference;
    }

    /**
     * @param string $finalDate
     */
    public function setFinalDate($finalDate)
    {
        $this->get['finalDate'] = $finalDate;
    }

    /**
     * @param string $initialDate
     */
    public function setInitialDate($initialDate)
    {
        $this->get['initialDate'] = $initialDate;
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
        $this->url = $this->seguiment[$this->version];
        return parent::send();
    }
}