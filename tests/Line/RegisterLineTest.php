<?php

use Clearvox\Asterisk\Dialplan\Line\RegisterLine;

class RegisterLineTest extends PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $register = new RegisterLine("123456", 'password', 'example.com');

        $this->assertEquals('register => 123456:password@example.com', $register->toString());
    }
}
 