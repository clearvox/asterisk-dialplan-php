<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\ChanSpy;
use PHPUnit\Framework\TestCase;

class ChanSpyTest extends TestCase
{
    /**
     * @var ChanSpy
     */
    public $chanSpy;

    public function setUp(): void
    {
        $this->chanSpy = new ChanSpy();
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('ChanSpy', $this->chanSpy->getName());
    }

    public function testSetGetChanPrefix()
    {
        $this->chanSpy->setChanPrefix('Agent');
        $this->assertEquals('Agent', $this->chanSpy->getChanPrefix());

        $chanSpy = new ChanSpy('Agent');
        $this->assertEquals('Agent', $chanSpy->getChanPrefix());
    }

    public function testSetGetOptions()
    {
        $options = ['b', 'c(5)', 'e(100:101)'];
        $this->chanSpy->setOptions($options);
        $this->assertEquals($options, $this->chanSpy->getOptions());

        $chanSpy = new ChanSpy('', $options);
        $this->assertEquals($options, $chanSpy->getOptions());
    }

    public function testGetDataOnlyPrefix()
    {
        $this->chanSpy->setChanPrefix('Agent');
        $this->assertEquals('Agent', $this->chanSpy->getData());
    }

    public function testGetDataOnlyOptions()
    {
        $options = ['b', 'c(5)', 'e(100:101)'];
        $this->chanSpy->setOptions($options);
        $this->assertEquals(',bc(5)e(100:101)', $this->chanSpy->getData());
    }

    public function testGetDataBoth()
    {
        $this->chanSpy
            ->setChanPrefix('Agent')
            ->setOptions(['b', 'c(5)', 'e(100:101)']);

        $this->assertEquals('Agent,bc(5)e(100:101)', $this->chanSpy->getData());
    }

    public function testString()
    {
        $this->assertEquals('ChanSpy()', $this->chanSpy->toString());

        $this->chanSpy
            ->setChanPrefix('Agent')
            ->setOptions(['b', 'c(5)', 'x(1)']);

        $this->assertEquals('ChanSpy(Agent,bc(5)x(1))', $this->chanSpy->toString());
    }
}