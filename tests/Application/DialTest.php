<?php

use Clearvox\Asterisk\Dialplan\Application\Dial;

class DialTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNameIsCorrect()
    {
        $dial = new Dial('SIP', 100);

        $this->assertEquals('Dial', $dial->getName());
    }

    public function testGetSingleTarget()
    {
        $dial = new Dial('SIP', 100);

        $this->assertEquals('SIP/100', $dial->getData());
    }

    public function testGetDataMultipleTargets()
    {
        $dial = new Dial('SIP', 100);
        $dial
            ->addTarget('SIP', 101)
            ->addTarget('SIP', 102);

        $this->assertEquals('SIP/100&SIP/101&SIP/102', $dial->getData());
    }

    public function testGetDataTimeout()
    {
        $dial = new Dial('SIP', 100, 30);

        $this->assertEquals('SIP/100,30', $dial->getData());
    }

    public function testGetDataSingleOption()
    {
        $dial = new Dial('SIP', 100, 30);
        $dial->addOption('o');

        $this->assertEquals('SIP/100,30,o', $dial->getData());
    }

    public function testGetDataMultipleOptions()
    {
        $dial = new Dial('SIP', 100, 30);
        $dial
            ->addOption('o')
            ->addOption('t')
            ->addOption('T');

        $this->assertEquals('SIP/100,30,otT', $dial->getData());
    }

    public function testGetDataURL()
    {
        $dial = new Dial('SIP', 100, 30, '/url');

        $this->assertEquals('SIP/100,30,,/url', $dial->getData());
    }
}
 