<?php

use Clearvox\Asterisk\Dialplan\Application\Read;

class ReadTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Read
     */
    public $read;

    public function setUp()
    {
        $this->read = new Read('TESTING');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('Read', $this->read->getName());
    }

    public function testGetDataIsCorrect()
    {
        // No extra data
        $this->assertEquals('TESTING', $this->read->getData());

        $this->read->addFilename('vm-password');
        $this->assertEquals('TESTING,vm-password', $this->read->getData());

        $this->read->setTimeout(5);
        $this->assertEquals('TESTING,,,,,5', $this->read->getData());
    }
}