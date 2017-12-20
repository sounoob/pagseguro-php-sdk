<?php

include_once 'source/Utils.php';

class UtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testNumbers()
    {
        $this->assertEquals('1156731493', Utils::onlyNumbers('(11) 5673-1493'));
        $this->assertEquals('01234567890', Utils::onlyNumbers('012.345.678-90'));
        $this->assertEquals('12031990', Utils::onlyNumbers('12/03/1990'));
    }
}
