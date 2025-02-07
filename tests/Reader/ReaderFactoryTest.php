<?php

use Clearvox\Asterisk\Dialplan\Reader\Reader;
use Clearvox\Asterisk\Dialplan\Reader\ReaderFactory;
use PHPUnit\Framework\TestCase;

class ReaderFactoryTest extends TestCase
{
    public function testCreate()
    {
        $readerFactory = new ReaderFactory();
        $reader = $readerFactory->create();

        $this->assertInstanceOf(Reader::class, $reader);
    }
}