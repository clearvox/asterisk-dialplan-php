<?php

namespace Line;

use Clearvox\Asterisk\Dialplan\Line\IncludeLine;
use PHPUnit\Framework\TestCase;

class IncludeLineTest extends TestCase
{
    public function testToString()
    {
        $includeLine = new IncludeLine("testing_context");

        $this->assertEquals('include => testing_context', $includeLine->toString());
    }
}
 