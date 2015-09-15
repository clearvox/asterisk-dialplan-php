<?php

use Clearvox\Asterisk\Dialplan\Application\GosubIf;

class GosubIfTest extends PHPUnit_Framework_TestCase
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

        $this->true  = $this->getMock('Clearvox\Asterisk\Dialplan\Application\Go', array('getData'), array(1));
        $this->false = $this->getMock('Clearvox\Asterisk\Dialplan\Application\Go', array('getData'), array(1));
    }

    public function testName()
    {
        $goSubIf = new GosubIf('1=1');
        $this->assertEquals('GosubIf', $goSubIf->getName());
    }

    public function testWithTrueCondition()
    {
        $this->true
            ->expects($this->once())
            ->method('getData')
            ->willReturn('telephones,100,1');

        $goSubIf = new GosubIf('1=1', $this->true);

        $this->assertEquals('GosubIf(1=1?telephones,100,1)', $goSubIf->toString());
    }

    public function testWithOnlyFalseCondition()
    {
        $this->false
            ->expects($this->once())
            ->method('getData')
            ->willReturn('phones,101,1');

        $goSubIf = new GosubIf('1=1', null, $this->false);

        $this->assertEquals('GosubIf(1=1?:phones,101,1)', $goSubIf->toString());
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

        $goSubIf = new GosubIf('1=1', $this->true, $this->false);

        $this->assertEquals('GosubIf(1=1?telephones,100,1:phones,101,1)', $goSubIf->toString());
    }

    public function testToArrayWithNoConditions()
    {
        $goSubIf = new GosubIf('1=1');
        $this->assertEquals(['condition' => '1=1'], $goSubIf->toArray());
    }
}