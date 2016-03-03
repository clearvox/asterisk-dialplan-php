<?php

use Clearvox\Asterisk\Dialplan\Application\Page;

class PageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetNameIsCorrect()
    {
        $dial = new Page('SIP', 100);

        $this->assertEquals('Page', $dial->getName());
    }

    public function testGetSingleTarget()
    {
        $dial = new Page('SIP', 100);

        $this->assertEquals('SIP/100', $dial->getData());
    }

    public function testGetDataMultipleTargets()
    {
        $dial = new Page('SIP', 100);
        $dial
            ->addTarget('SIP', 101)
            ->addTarget('SIP', 102);

        $this->assertEquals('SIP/100&SIP/101&SIP/102', $dial->getData());
    }

    public function testGetDataTimeout()
    {
        $dial = new Page('SIP', 100, 30);

        $this->assertEquals('SIP/100,,30', $dial->getData());
    }

    public function testGetDataSingleOption()
    {
        $dial = new Page('SIP', 100);
        $dial->addOption('q');

        $this->assertEquals('SIP/100,q', $dial->getData());
    }

    public function testGetDataMultipleOptions()
    {
        $dial = new Page('SIP', 100, 30);
        $dial
            ->addOption('q')
            ->addOption('d');

        $this->assertEquals('SIP/100,qd,30', $dial->getData());
    }

    public function testGetTargets()
    {
        $dial = new Page('SIP', 100);
        $dial
            ->addTarget('SIP', 101)
            ->addTarget('SIP', 102);

        $expectedTargets = array(
            array('SIP', 100),
            array('SIP', 101),
            array('SIP', 102)
        );

        $this->assertEquals($expectedTargets, $dial->getTargets());
    }

    public function testGetOptions()
    {
        $dial = new Page('SIP', 100, 30);
        $dial
            ->addOption('q')
            ->addOption('d')
            ->addOption('b(test)');

        $this->assertEquals(array('q', 'd', 'b(test)'), $dial->getOptions());
    }
}
 