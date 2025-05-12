<?php

use Clearvox\Asterisk\Dialplan\Dialplan;
use Clearvox\Asterisk\Dialplan\Exception\LineNotFoundAtPriorityException;
use Clearvox\Asterisk\Dialplan\Line\ExtenLine;
use Clearvox\Asterisk\Dialplan\Line\LineInterface;
use PHPUnit\Framework\TestCase;

class DialplanTest extends TestCase
{
    public function testDialplanReturnsContextName()
    {
        $line = $this->createMock(LineInterface::class);

        $dialplan = new Dialplan('testing_context', $line);
        $this->assertEquals('testing_context', $dialplan->getName());
    }

    public function testDialplanOverridesContextName()
    {
        $dialplan = new Dialplan('testing_context');
        $this->assertEquals('testing_context', $dialplan->getName());
        $dialplan->setName('changing_context');
        $this->assertEquals('changing_context', $dialplan->getName());
    }

    public function testAddLineCorrectlyHasRightPriority()
    {
        $line = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $line2 = clone $line;

        $dialplan = new Dialplan('line_context', $line);
        $dialplan->addLine($line2);

        $this->assertEquals(array(0 => $line, 1 => $line2), $dialplan->getLines());
    }

    public function testDialplanToString()
    {
        $line = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $line
            ->expects($this->once())
            ->method('toString')
            ->willReturn('exten => 100,1,Dial(SIP/100)');

        $line2 = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
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
            ->addLine($this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface'))
            ->addLine($this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface'));

        $this->assertEquals(3, $dialplan->getNextPriority());
    }

    public function testDialplanGetNextPriorityWithPattern()
    {
        $firstMock = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $firstMock
            ->expects($this->once())
            ->method('getPattern')
            ->willReturn('*1');

        $secondMock = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
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
        $firstMock = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $firstMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('*1');

        $secondMock = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
        $secondMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('*2');

        $thirdMock = $this->createMock('Clearvox\Asterisk\Dialplan\Line\LineInterface');
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

    /**
     * @throws LineNotFoundAtPriorityException
     */
    public function testGetLine()
    {
        $dialplan = new Dialplan('testing_lines');

        $firstMock = $this->createMock(LineInterface::class);
        $firstMock
            ->expects($this->exactly(2))
            ->method('getPattern')
            ->willReturn('100');

        $firstMock
            ->expects($this->exactly(2))
            ->method('getPriority')
            ->willReturn('1');

        $dialplan->addLine($firstMock);

        $this->assertSame($firstMock, $dialplan->getLine('100', 1));

        try {
            $dialplan->getLine('100', 2);
        } catch (Exception $e) {
            $this->assertInstanceOf(LineNotFoundAtPriorityException::class, $e);
            return;
        }

        $this->fail("No exception thrown for dialplan::getLine(100,2)");
    }

    public function testHasLine()
    {
        $dialplan = new Dialplan('testing_has_line');

        $firstMock = $this->createMock(LineInterface::class);
        $firstMock
            ->expects($this->exactly(4))
            ->method('getPattern')
            ->willReturn('200');

        $firstMock
            ->expects($this->exactly(1))
            ->method('getPriority')
            ->willReturn('1');

        $dialplan->addLine($firstMock);

        $this->assertTrue($dialplan->hasLine("200", '1'));
        $this->assertFalse($dialplan->hasLine("300", '1'));
        $this->assertTrue($dialplan->hasLine("200"));
        $this->assertFalse($dialplan->hasLine("300"));
    }

    /**
     * @throws LineNotFoundAtPriorityException
     */
    public function testRemoveLine()
    {
        $dialplan = new Dialplan('testing_remove_line');

        $firstMock = $this->createMock(LineInterface::class);
        $firstMock
            ->expects($this->atLeastOnce())
            ->method('getPattern')
            ->willReturn('200');

        $firstMock
            ->expects($this->atLeastOnce())
            ->method('getPriority')
            ->willReturn('10');

        $secondMock = $this->createMock(LineInterface::class);
        $secondMock
            ->expects($this->atLeastOnce())
            ->method('getPattern')
            ->willReturn('200');

        $secondMock
            ->expects($this->atLeastOnce())
            ->method('getPriority')
            ->willReturn('11');

        $dialplan
            ->addLine($firstMock)
            ->addLine($secondMock);

        $this->assertCount(2, $dialplan->getLines());
        $dialplan->removeLine("200", 10);
        $this->assertCount(1, $dialplan->getLines());

        try {
            $dialplan->removeLine("200", 12);
        } catch (Exception $e) {
            $this->assertInstanceOf(LineNotFoundAtPriorityException::class, $e);
            return;
        }

        $this->fail('Missing exception');
    }

    public function testRemoveLines()
    {
        $dialplan = new Dialplan('testing_removing_lines');

        $firstMock = $this->createMock(LineInterface::class);
        $firstMock
            ->expects($this->atLeastOnce())
            ->method('getPattern')
            ->willReturn('200');

        $secondMock = $this->createMock(LineInterface::class);
        $secondMock
            ->expects($this->atLeastOnce())
            ->method('getPattern')
            ->willReturn('200');

        $dialplan
            ->addLine($firstMock)
            ->addline($secondMock);

        $this->assertCount(2, $dialplan->getLines());
        $dialplan->removeLines("200");
        $this->assertCount(0, $dialplan->getLines());
    }

    public function testAddLineToTopAddsLineAtTheTop()
    {
        $dialplan = new Dialplan('test_context');

        // Mock first line with pattern "100" and priority 1 (supports setPriority)
        $existingLine = $this->createMock(ExtenLine::class);
        $existingLine->method('getPattern')->willReturn('100');
        $existingLine->method('getPriority')->willReturn('1');
        $existingLine->method('toString')->willReturn('exten => 100,1,Dial(SIP/100)');
        $existingLine->expects($this->once())->method('setPriority')->with("2");

        // Mock second line with pattern "200" (does not match)
        $existingLine2 = $this->createMock(ExtenLine::class);
        $existingLine2->method('getPattern')->willReturn('200');
        $existingLine2->method('getPriority')->willReturn("1");
        $existingLine2->method('toString')->willReturn('exten => 200,1,Dial(SIP/200)');

        // Add existing lines
        $dialplan->addLine($existingLine);
        $dialplan->addLine($existingLine2);

        // Mock new line to add at the top
        $newLine = $this->createMock(ExtenLine::class);
        $newLine->method('getPattern')->willReturn('100');
        $newLine->method('toString')->willReturn('exten => 100,1,Answer()');

        $dialplan->addLineToTop($newLine, '100');

        // Get updated lines
        $lines = $dialplan->getLines();

        $this->assertSame($newLine, $lines[0]);
    }

    public function testAddLineToTopDoesNotModifyLinesWithoutPriority()
    {
        $dialplan = new Dialplan('test_context');

        // Mock a line that does not have a priority (like IncludeLine)
        $includeLine = $this->createMock(LineInterface::class);
        $includeLine->method('getPattern')->willReturn('');
        $includeLine->method('getPriority')->willReturn('');
        $includeLine->method('toString')->willReturn('include => default');

        // Mock a normal dialplan line with a priority
        $existingLine = $this->createMock(LineInterface::class);
        $existingLine->method('getPattern')->willReturn('100');
        $existingLine->method('toString')->willReturn('exten => 100,Dial(SIP/100)');

        // Add lines
        $dialplan->addLine($includeLine);
        $dialplan->addLine($existingLine);

        // Mock new line to add at the top
        $newLine = $this->createMock(LineInterface::class);
        $newLine->method('getPattern')->willReturn('100');
        $newLine->method('toString')->willReturn('exten => 100,hint,Answer()');

        $dialplan->addLineToTop($newLine, '100');

        // Get updated lines
        $lines = $dialplan->getLines();

        $this->assertSame($newLine, $lines[0]);
        $this->assertSame($includeLine, $lines[1]);
        $this->assertSame($existingLine, $lines[2]);
    }
}
 