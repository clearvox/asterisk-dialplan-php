<?php

use Clearvox\Asterisk\Dialplan\Application\Hangup;
use PHPUnit\Framework\TestCase;

class HangupTest extends TestCase
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