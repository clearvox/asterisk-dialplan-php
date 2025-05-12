<?php

namespace Reader\Application;

use Clearvox\Asterisk\Dialplan\Application\NoOp;
use Clearvox\Asterisk\Dialplan\Reader\Application\NoOpReader;
use PHPUnit\Framework\TestCase;

class NoOpReaderTest extends TestCase
{
    public function testGetInstance()
    {
        $noOpReader = new NoOpReader();

        $lineOne = 'NoOp(Testing hello world)';
        $lineTwo = 'NoOp(SingleWord)';

        $pattern = $noOpReader->getMatchFormat();

        $lineOneMatches = [];
        $lineOneResponse = preg_match($pattern, $lineOne, $lineOneMatches);

        $lineOneApplication = $noOpReader->getInstance($lineOneMatches);

        $this->assertEquals(1, $lineOneResponse);
        $this->assertInstanceOf(NoOp::class, $lineOneApplication);
        $this->assertEquals('Testing hello world', $lineOneApplication->getText());


        $lineTwoMatches = [];
        $lineTwoResponse = preg_match($pattern, $lineTwo, $lineTwoMatches);

        $lineTwoApplication = $noOpReader->getInstance($lineTwoMatches);

        $this->assertEquals(1, $lineTwoResponse);
        $this->assertInstanceOf(NoOp::class, $lineTwoApplication);
        $this->assertEquals('SingleWord', $lineTwoApplication->getText());
    }
}