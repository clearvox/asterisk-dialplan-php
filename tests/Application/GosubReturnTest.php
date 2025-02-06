<?php

use Clearvox\Asterisk\Dialplan\Application\GosubReturn;
use PHPUnit\Framework\TestCase;

class GosubReturnTest extends TestCase
{
    public function testGetName()
    {
        $return = new GosubReturn();
        $this->assertEquals('Return', $return->getName());
    }

    public function testGetDataEmpty()
    {
        $return = new GosubReturn();
        $this->assertEquals('', $return->getData());
    }

    public function testGetData()
    {
        $return = new GosubReturn('PASSED');
        $this->assertEquals('PASSED', $return->getData());
    }
}