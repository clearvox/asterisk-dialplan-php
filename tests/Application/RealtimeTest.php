<?php

use Clearvox\Asterisk\Dialplan\Application\Realtime;
use PHPUnit\Framework\TestCase;

class RealtimeTest extends TestCase
{
    public function testGetNameIsCorrect()
    {
        $realtime = new Realtime();

        $this->assertEquals('Realtime', $realtime->getName());
    }

    public function testJustContext()
    {
        $realtime = new Realtime('my_context');

        $this->assertEquals('Realtime/my_context@', $realtime->toString());
    }

    public function testContextAndFamily()
    {
        $realtime = new Realtime('my_context', 'extens');

        $this->assertEquals('Realtime/my_context@extens', $realtime->toString());
    }
}
 