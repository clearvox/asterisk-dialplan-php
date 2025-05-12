<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\Ringing;
use PHPUnit\Framework\TestCase;

class RingingTest extends TestCase
{
    public function testToString()
    {
        $ringing = new Ringing();
        $this->assertEquals('Ringing()', $ringing->toString());
    }
}
 