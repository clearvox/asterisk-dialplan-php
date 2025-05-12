<?php

namespace Clearvox\Asterisk\Dialplan\Functions;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Line\ExtenLine;
use PHPUnit\Framework\TestCase;

class ExtenLineTest extends TestCase
{
    public function testCorrectStringReturn()
    {
        $application = $this->createMock(ApplicationInterface::class);

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
        $application = $this->createMock(ApplicationInterface::class);

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
 