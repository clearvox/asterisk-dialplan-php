<?php

use Clearvox\Asterisk\Dialplan\Reader\Reader;
use Clearvox\Asterisk\Dialplan\Reader\ReaderFactory;

class ReaderFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $readerFactory = new ReaderFactory();
        $reader = $readerFactory->create();

        $this->assertInstanceOf(Reader::class, $reader);
    }
}