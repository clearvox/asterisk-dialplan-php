<?php

use Clearvox\Asterisk\Dialplan\Line\IncludeLine;

class IncludeLineTest extends PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $includeLine = new IncludeLine("testing_context");

        $this->assertEquals('include => testing_context', $includeLine->toString());
    }
}
 