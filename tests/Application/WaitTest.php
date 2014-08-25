<?php

use Clearvox\Asterisk\Dialplan\Application\Wait;

class WaitTest extends PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $wait = new Wait(30);
        $this->assertEquals('Wait(30)', $wait->toString());
    }
}
 