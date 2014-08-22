<?php

use Clearvox\Asterisk\Dialplan\Line\SwitchLine;

class SwitchLineTest extends PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $application = $this->getMock('Clearvox\Asterisk\Dialplan\Application\Realtime');

        $application
            ->expects($this->once())
            ->method('toString')
            ->willReturn('Realtime/@');

        $switchLine = new SwitchLine($application);

        $this->assertEquals(
            'switch => Realtime/@',
            $switchLine->toString()
        );
    }
}
 