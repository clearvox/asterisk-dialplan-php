<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\SIPAddHeader;
use PHPUnit\Framework\TestCase;

class SIPAddHeaderTest  extends TestCase
{

    public function testGetNameIsCorrect()
    {
        $sipAddHeader = new SIPAddHeader('Alert-Info', '\;info=alert-autoanswer');

        $this->assertEquals('SIPAddHeader', $sipAddHeader->getName());
    }

    public function testArguments()
    {
        $sipAddHeader = new SIPAddHeader('Alert-Info', '\;info=alert-autoanswer');

        $this->assertEquals('Alert-Info: \;info=alert-autoanswer', $sipAddHeader->getData());
    }

    public function testToString()
    {
        $sipAddHeader = new SIPAddHeader('Alert-Info', '\;info=alert-autoanswer');

        $this->assertEquals('SIPAddHeader(Alert-Info: \;info=alert-autoanswer)', $sipAddHeader->toString());
    }

}