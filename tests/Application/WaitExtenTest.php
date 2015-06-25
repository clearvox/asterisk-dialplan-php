<?php
use Clearvox\Asterisk\Dialplan\Application\WaitExten;

class WaitExtenTest extends PHPUnit_Framework_TestCase
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
        $this->waitExten->setOptions(['m(/path/to/music/file)']);
        $this->assertEquals('WaitExten(,m(/path/to/music/file))', $this->waitExten->toString());
    }

    public function testWithWaitTimeAndOptions()
    {
        $this->waitExten->setSeconds(45);
        $this->waitExten->setOptions(['m(/path/to/music/file)']);
        $this->assertEquals('WaitExten(45,m(/path/to/music/file))', $this->waitExten->toString());
    }
}