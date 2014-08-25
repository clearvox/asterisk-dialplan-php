<?php

use Clearvox\Asterisk\Dialplan\Application\Ringing;

class RingingTest extends PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $ringing = new Ringing();
        $this->assertEquals('Ringing()', $ringing->toString());
    }
}
 