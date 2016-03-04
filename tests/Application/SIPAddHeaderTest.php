<?php
use Clearvox\Asterisk\Dialplan\Application\SIPAddHeader;

class SIPAddHeaderTest extends \PHPUnit_Framework_TestCase
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