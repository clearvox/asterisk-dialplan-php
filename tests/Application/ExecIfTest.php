<?php

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Application\ExecIf;
use PHPUnit\Framework\TestCase;

class ExecIfTest extends TestCase
{
    public $expression = '$["${CHANNEL(state)}" != "Up"]';

    /**
     * @var ExecIf
     */
    public $execIf;

    protected function setUp()
    {
        $applicationMock = $this->getMock();

        $applicationMock
            ->expects($this->any())
            ->method('toString')
            ->willReturn('Answer');

        $this->execIf = new ExecIf($this->expression, $applicationMock);
    }

    public function testGetName()
    {
        $this->assertEquals('ExecIf', $this->execIf->getName());
    }

    public function testGetData()
    {
        $expected = $this->expression . '?Answer';
        $this->assertEquals($expected, $this->execIf->getData());
    }

    public function testOnlyTrueToString()
    {
        $expected = "ExecIf({$this->expression}?Answer)";
        $this->assertEquals($expected, $this->execIf->toString());
    }

    public function testWithFalseData()
    {
        $noOpApplication = $this->getMock('Clearvox\Asterisk\Dialplan\Application\ApplicationInterface');
        $noOpApplication
            ->expects($this->once())
            ->method('toString')
            ->willReturn('NoOp(Answered)');

        $this->execIf->setFalse($noOpApplication);

        $expected = $this->expression . '?Answer:NoOp(Answered)';
        $this->assertEquals($expected, $this->execIf->getData());
    }

    public function testWithFalseString()
    {
        $noOpApplication = $this->getMock('Clearvox\Asterisk\Dialplan\Application\ApplicationInterface');
        $noOpApplication
            ->expects($this->once())
            ->method('toString')
            ->willReturn('NoOp(Answered)');

        $this->execIf->setFalse($noOpApplication);

        $expected = "ExecIf({$this->expression}?Answer:NoOp(Answered))";
        $this->assertEquals($expected, $this->execIf->toString());
    }

    private function getMock()
    {
        return $this->getMockBuilder(ApplicationInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}