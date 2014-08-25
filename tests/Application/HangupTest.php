<?php

use Clearvox\Asterisk\Dialplan\Application\Hangup;

class HangupTest extends PHPUnit_Framework_TestCase
{
    public function testEmptyToString()
    {
        $hangup = new Hangup();
        $this->assertEquals('Hangup()', $hangup->toString());
    }

    public function testWithCauseToString()
    {
        $hangup = new Hangup(300);
        $this->assertEquals('Hangup(300)', $hangup->toString());
    }
}