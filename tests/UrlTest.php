<?php

include_once 'source/config/Config.php';

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testProdUrl()
    {
        Config::setProduction();
        $this->assertEquals('https://ws.pagseguro.uol.com.br/', URL::getWs());
        $this->assertEquals('https://pagseguro.uol.com.br/', URL::getPage());
        $this->assertEquals('https://stc.pagseguro.uol.com.br/', URL::getStc());
    }
    public function testSandboxUrl()
    {
        Config::setSandbox();
        $this->assertEquals('https://ws.sandbox.pagseguro.uol.com.br/', URL::getWs());
        $this->assertEquals('https://sandbox.pagseguro.uol.com.br/', URL::getPage());
        $this->assertEquals('https://stc.sandbox.pagseguro.uol.com.br/', URL::getStc());
    }
}
