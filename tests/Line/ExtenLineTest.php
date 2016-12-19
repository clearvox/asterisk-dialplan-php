<?php

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Line\ExtenLine;

class ExtenLineTest extends \PHPUnit_Framework_TestCase
{
    public function testCorrectStringReturn()
    {
        $application = $this->getMock('Clearvox\Asterisk\Dialplan\Application\ApplicationInterface');

        $application
            ->expects($this->once())
            ->method('toString')
            ->willReturn('Dial(SIP/100)');

        $extenLine = new ExtenLine('_XXX', 1, $application);

        $this->assertEquals(
            'exten => _XXX,1,Dial(SIP/100)',
            $extenLine->toString()
        );
    }

    public function testCorrectStringReturnWithLabel()
    {
        $application = $this->getMock('Clearvox\Asterisk\Dialplan\Application\ApplicationInterface');

        $application
            ->expects($this->once())
            ->method('toString')
            ->willReturn('Dial(SIP/100)');

        $extenLine = new ExtenLine('_XXX', 1, $application);
        $extenLine->setLabel('starting');

        $this->assertEquals(
            'exten => _XXX,1(starting),Dial(SIP/100)',
            $extenLine->toString()
        );
    }
}
 