<?php

use Clearvox\Asterisk\Dialplan\Reader\Application\NoOpReader;
use Clearvox\Asterisk\Dialplan\Reader\Line\ExtenLineReader;
use Clearvox\Asterisk\Dialplan\Reader\Reader;

class ReaderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Reader
     */
    public $reader;

    public function setUp()
    {
        $this->reader = new Reader([new ExtenLineReader([new NoOpReader])]);
    }

    public function testSimpleDialplan()
    {
        $dialplan = $this->reader->read(file_get_contents(__DIR__ . '/source-examples/simple-dialplan.txt'));

        $this->assertEquals('dialplan_context_1', $dialplan->getName());
        $this->assertEquals(3, count($dialplan->getLines()));
    }

    public function testAdvancedDialplan()
    {
        $dialplan = $this->reader->read(file_get_contents(__DIR__ . '/source-examples/advanced-dialplan.txt'));

        $this->assertEquals('ea91e4f9-633c-4fa6-b357-438078ecf585', $dialplan->getName());
        $this->assertEquals(28, count($dialplan->getLines()));


        var_dump($dialplan->getLines());
    }
}