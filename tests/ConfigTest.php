<?php
class ConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testEnv()
    {
        \Sounoob\pagseguro\config\Config::setProduction();
        $this->assertEquals(false, \Sounoob\pagseguro\config\Config::isSandbox());

        \Sounoob\pagseguro\config\Config::setSandbox();
        $this->assertEquals(true, \Sounoob\pagseguro\config\Config::isSandbox());
    }
    public function testToken()
    {
        \Sounoob\pagseguro\config\Config::setProduction();
        $this->assertEquals(32, strlen(\Sounoob\pagseguro\config\Config::getToken()));

        \Sounoob\pagseguro\config\Config::setSandbox();
        $this->assertEquals(32, strlen(\Sounoob\pagseguro\config\Config::getToken()));
    }
}
