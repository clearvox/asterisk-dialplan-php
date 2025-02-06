<?php

use Clearvox\Asterisk\Dialplan\Application\Wait;
use PHPUnit\Framework\TestCase;

class WaitTest extends TestCase
{
    public function testToString()
    {
        $wait = new Wait(30);
        $this->assertEquals('Wait(30)', $wait->toString());
    }
}
 