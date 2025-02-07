<?php
use Clearvox\Asterisk\Dialplan\Application\WaitExten;
use PHPUnit\Framework\TestCase;

class WaitExtenTest extends TestCase
{
    /**
     * @var WaitExten
     */
    protected $waitExten;

    public function setUp()
    {
        $this->waitExten = new WaitExten();
    }

    public function testName()
    {
        $this->assertEquals('WaitExten', $this->waitExten->getName());
    }

    public function testWithWaitTime()
    {
        $this->waitExten->setSeconds(45);

        $this->assertEquals('WaitExten(45)', $this->waitExten->toString());
    }

    public function testWithOptions()
    {
        $this->waitExten->setOptions(['m(default)']);
        $this->assertEquals('WaitExten(,m(default))', $this->waitExten->toString());
    }

    public function testWithWaitTimeAndOptions()
    {
        $this->waitExten->setSeconds(45);
        $this->waitExten->setOptions(['m(default)']);
        $this->assertEquals('WaitExten(45,m(default))', $this->waitExten->toString());
    }
}