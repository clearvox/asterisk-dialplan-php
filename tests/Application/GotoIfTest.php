<?php

use Clearvox\Asterisk\Dialplan\Application\Go;
use Clearvox\Asterisk\Dialplan\Application\GotoIf;
use PHPUnit\Framework\TestCase;

class GotoIfTest extends TestCase
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
        $gotoif = new GotoIf('1=1');
        $this->assertEquals('GotoIf', $gotoif->getName());
    }

    public function testWithTrueCondition()
    {
        $this->true
            ->expects($this->once())
            ->method('getData')
            ->willReturn('telephones,100,1');

        $gotoif = new GotoIf('1=1', $this->true);

        $this->assertEquals('GotoIf(1=1?telephones,100,1)', $gotoif->toString());
    }

    public function testWithOnlyFalseCondition()
    {
        $this->false
            ->expects($this->once())
            ->method('getData')
            ->willReturn('phones,101,1');

        $gotoif = new GotoIf('1=1', null, $this->false);

        $this->assertEquals('GotoIf(1=1?:phones,101,1)', $gotoif->toString());
    }

    public function testWithTrueAndFalseCondition()
    {
        $this->true
            ->expects($this->once())
            ->method('getData')
            ->willReturn('telephones,100,1');

        $this->false
            ->expects($this->once())
            ->method('getData')
            ->willReturn('phones,101,1');

        $gotoif = new GotoIf('1=1', $this->true, $this->false);

        $this->assertEquals('GotoIf(1=1?telephones,100,1:phones,101,1)', $gotoif->toString());
    }
}
 