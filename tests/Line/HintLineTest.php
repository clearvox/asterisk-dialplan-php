<?php

use Clearvox\Asterisk\Dialplan\Line\HintLine;

class HintLineTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HintLine
     */
    public $hintLine;

    public function setUp()
    {
        $this->hintLine = new HintLine('100');
    }

    public function testGetPattern()
    {
        $this->assertEquals('100', $this->hintLine->getPattern());
    }

    public function testGetPriority()
    {
        $this->assertEquals('hint', $this->hintLine->getPriority());
    }

    public function testGetPeers()
    {
        $this->hintLine
            ->addPeer('SIP/100')
            ->addPeer('SIP/200');

        $this->assertEquals(['SIP/100', 'SIP/200'], $this->hintLine->getPeers());
    }

    public function testToStringOnePeer()
    {
        $this->hintLine
            ->addPeer('SIP/100');

        $expected = "exten => 100,hint,SIP/100";
        $this->assertEquals($expected, $this->hintLine->toString());
    }

    public function testToStringManyPeers()
    {
        $this->hintLine
            ->addPeer('SIP/100')
            ->addPeer('SIP/200')
            ->addPeer('SIP/300');

        $expected = "exten => 100,hint,SIP/100&SIP/200&SIP/300";
        $this->assertEquals($expected, $this->hintLine->toString());
    }
}