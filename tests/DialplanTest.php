<?php

use Clearvox\Asterisk\Dialplan\Dialplan;
use Clearvox\Asterisk\Dialplan\Exception\LineNotFoundAtPriorityException;
use Clearvox\Asterisk\Dialplan\Line\LineInterface;

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

    public function testDialplanGetNextPriorityWithPattern()
    {
        $firstMock = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $firstMock
            ->expects($this->once())
            ->method('getPattern')
            ->willReturn('*1');

        $secondMock = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $secondMock
            ->expects($this->once())
            ->method('getPattern')
            ->willReturn('*1');

        $dialplan = new Dialplan('testing_context');
        $dialplan
            ->addLine($firstMock)
            ->addLine($secondMock);

        $this->assertEquals(3, $dialplan->getNextPriority('*1'));
    }

    public function testDialplanGetNextPriorityWithMultiplePatterns()
    {
        $firstMock = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $firstMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('*1');

        $secondMock = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $secondMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('*2');

        $thirdMock = $this->getMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $thirdMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('*2');

        $dialplan = new Dialplan('testing_context');
        $dialplan
            ->addLine($firstMock)
            ->addLine($secondMock)
            ->addLine($thirdMock);

        $this->assertEquals(2, $dialplan->getNextPriority('*1'));
        $this->assertEquals(3, $dialplan->getNextPriority('*2'));
    }

    public function testDialplanExtension()
    {
        $dialplan = new Dialplan('example_dialplan');
        $dialplan->setExtended(true);

        $expected = "[example_dialplan](+)\n\n";

        $this->assertEquals($expected, $dialplan->toString());
    }

    public function testGetLine()
    {
        $dialplan = new Dialplan('testing_lines');

        $firstMock = $this->getMock(LineInterface::class);
        $firstMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('100');

        $firstMock
            ->expects($this->exactly(2))
            ->method('getPriority')
            ->willReturn(1);

        $dialplan->addLine($firstMock);

        $this->assertSame($firstMock, $dialplan->getLine('100', 1));

        try {
            $dialplan->getLine('100', 2);
        } catch(\Exception $e) {
            $this->assertInstanceOf(LineNotFoundAtPriorityException::class, $e);
            return;
        }
        
        $this->fail("No exception thrown for dialplan::getLine(100,2)");
    }

    public function testHasLine()
    {
        $dialplan = new Dialplan('testing_has_line');

        $firstMock = $this->getMock(LineInterface::class);
        $firstMock
            ->expects($this->exactly(4))
            ->method('getPattern')
            ->willReturn('200');

        $firstMock
            ->expects($this->exactly(1))
            ->method('getPriority')
            ->willReturn(1);

        $dialplan->addLine($firstMock);

        $this->assertTrue($dialplan->hasLine("200", 1));
        $this->assertFalse($dialplan->hasLine("300", 1));
        $this->assertTrue($dialplan->hasLine("200"));
        $this->assertFalse($dialplan->hasLine("300"));
    }
}
 