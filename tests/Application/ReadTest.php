<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\Read;
use PHPUnit\Framework\TestCase;

class ReadTest extends TestCase
{
    /**
     * @var Read
     */
    public $read;

    public function setUp(): void
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
        $this->assertEquals('TESTING,vm-password,,,,5', $this->read->getData());
    }
}