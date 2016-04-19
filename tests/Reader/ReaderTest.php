<?php

use Clearvox\Asterisk\Dialplan\Reader\Reader;

class ReaderTest extends PHPUnit_Framework_TestCase
{
    public $reader;

    public function setUp()
    {
        $this->reader = new Reader();
    }

    public function testReadinginINI()
    {
        $simpleExample = file_get_contents(__DIR__ . '/source-examples/simple-dialplan.txt');
        $this->reader->read($simpleExample);
    }
}