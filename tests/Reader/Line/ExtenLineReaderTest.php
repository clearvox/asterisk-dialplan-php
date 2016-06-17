<?php

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Line\ExtenLine;
use Clearvox\Asterisk\Dialplan\Reader\Line\ExtenLineReader;

class ExtenLineReaderTest extends PHPUnit_Framework_TestCase
{
    public $testString = "exten => 100,1,NoOp(Hello world)";

    public function testMatchFormat()
    {
        $extenLineReader = new ExtenLineReader();
        $format = $extenLineReader->getMatchFormat();

        $preg = preg_match($format, $this->testString);
        $this->assertTrue($preg === 1);
    }

    public function testGetInstance()
    {
        $extenLineReader = new ExtenLineReader();

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $this->testString, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('100', $line->getPattern());
        $this->assertEquals('1', $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }
}