<?php

include_once 'source/Utils.php';

class UtilsTest extends \PHPUnit\Framework\TestCase
{
    public function testNumbers()
    {
        $this->utils = new Utils();

        $this->assertEquals('1156731493', $this->utils->only_numbers('(11) 5673-1493'));
        $this->assertEquals('01234567890', $this->utils->only_numbers('012.345.678-90'));
        $this->assertEquals('12031990', $this->utils->only_numbers('12/03/1990'));
    }
}
