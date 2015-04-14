<?php

use Clearvox\Asterisk\Dialplan\Application\ExtenSpy;

class ExtenSpyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ExtenSpy
     */
    public $extenSpy;

    public function setUp()
    {
        $this->extenSpy = new ExtenSpy('100');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('ExtenSpy', $this->extenSpy->getName());
    }

    public function testSetGetOptions()
    {
        $options = ['b', 'c(5)', 'e(101:102)'];
        $this->extenSpy->setOptions($options);
        $this->assertEquals($options, $this->extenSpy->getOptions());

        $extenSpy = new ExtenSpy('100', $options);
        $this->assertEquals($options, $extenSpy->getOptions());
    }

    public function testGetDataOptions()
    {
        $options = ['b', 'c(5)', 'e(101:102)'];
        $this->extenSpy->setOptions($options);
        $this->assertEquals('100,bc(5)e(101:102)', $this->extenSpy->getData());
    }

    public function testString()
    {
        $this->assertEquals('ExtenSpy(100)', $this->extenSpy->toString());

        $this->extenSpy
            ->setOptions(['b', 'c(5)', 'x(1)']);

        $this->assertEquals('ExtenSpy(100,bc(5)x(1))', $this->extenSpy->toString());
    }
}