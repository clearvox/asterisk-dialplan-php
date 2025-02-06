<?php

use Clearvox\Asterisk\Dialplan\Application\Go;
use Clearvox\Asterisk\Dialplan\Application\GotoIfTime;
use PHPUnit\Framework\TestCase;

class GotoIfTimeTest extends TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    public $true;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    public $false;

    public function setUp()
    {
        parent::setUp();

        $this->true  = $this->createMock(Go::class);
        $this->false = $this->createMock(Go::class);
    }

    public function testName()
    {
        $ifTime = new GotoIfTime('*', '*', '*', '*');
        $this->assertEquals('GotoIfTime', $ifTime->getName());
    }

    public function testToString()
    {
        $ifTime = new GotoIfTime('1300-1500', 'mon-fri', '1-31', 'jan');
        $this->assertEquals('GotoIfTime(1300-1500,mon-fri,1-31,jan,?)', $ifTime->toString());
    }

    public function testToStringWithTimezone()
    {
        $ifTime = new GotoIfTime('1300-1500', 'mon-fri', '1-31', 'jan', 'Amsterdam');
        $this->assertEquals('GotoIfTime(1300-1500,mon-fri,1-31,jan,Amsterdam?)', $ifTime->toString());
    }

    public function testToStringWithTrueCondition()
    {
        $this->true
            ->expects($this->once())
            ->method('getData')
            ->willReturn('telephones,101,1');

        $ifTime = new GotoIfTime('1300-1500', 'mon-fri', '1-31', 'jan', 'Amsterdam', $this->true);
        $this->assertEquals('GotoIfTime(1300-1500,mon-fri,1-31,jan,Amsterdam?telephones,101,1:)', $ifTime->toString());
    }

    public function testToStringWithFalseCondition()
    {
        $this->true
            ->expects($this->once())
            ->method('getData')
            ->willReturn('telephones,101,1');

        $this->false
            ->expects($this->once())
            ->method('getData')
            ->willReturn('phones,100,1');

        $ifTime = new GotoIfTime('1300-1500', 'mon-fri', '1-31', 'jan', 'Amsterdam', $this->true, $this->false);
        $this->assertEquals(
            'GotoIfTime(1300-1500,mon-fri,1-31,jan,Amsterdam?telephones,101,1:phones,100,1)',
            $ifTime->toString()
        );
    }
}
 