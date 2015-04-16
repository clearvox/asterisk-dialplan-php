<?php

use Clearvox\Asterisk\Dialplan\Dialplan;

class DialplanTest extends PHPUnit_Framework_TestCase
{
    public function testDialplanReturnsContextName()
    {
        $line = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface', array('getPattern', 'getApplication', 'toString', 'getPriority'));

        $dialplan = new Dialplan('testing_context', $line);
        $this->assertEquals('testing_context', $dialplan->getName());
    }

    public function testAddLineCorrectlyHasRightPriority()
    {
        $line = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $line2 = clone $line;

        $dialplan = new Dialplan('line_context', $line);
        $dialplan->addLine($line2);

        $this->assertEquals(array(0 => $line, 1 => $line2), $dialplan->getLines());
    }

    public function testDialplanToString()
    {
        $line = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $line
            ->expects($this->once())
            ->method('toString')
            ->willReturn('exten => 100,1,Dial(SIP/100)');

        $line2 = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $line2
            ->expects($this->once())
            ->method('toString')
            ->willReturn('exten => 101,1,Dial(SIP/101)');

        $dialplan = new Dialplan('new_context', $line);
        $dialplan->addLine($line2);

        $expected = "[new_context]\n";
        $expected .= "exten => 100,1,Dial(SIP/100)\n";
        $expected .= "exten => 101,1,Dial(SIP/101)\n";
        $expected .= "\n";

        $this->assertEquals($expected, $dialplan->toString());
    }

    public function testDialplanGetNextPriority()
    {
        $dialplan = new Dialplan('testing_context');
        $dialplan
            ->addLine($this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface'))
            ->addLine($this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface'));

        $this->assertEquals(3, $dialplan->getNextPriority());
    }
}
 