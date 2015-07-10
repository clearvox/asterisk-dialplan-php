<?php

use Clearvox\Asterisk\Dialplan\Application\GosubReturn;

class GosubReturnTest extends PHPUnit_Framework_TestCase
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