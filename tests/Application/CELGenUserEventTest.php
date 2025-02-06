<?php

use Clearvox\Asterisk\Dialplan\Application\CELGenUserEvent;
use PHPUnit\Framework\TestCase;

class CELGenUserEventTest extends TestCase
{
    /**
     * @var CELGenUserEvent
     */
    protected $genUserEvent;

    public function setUp()
    {
        $this->genUserEvent = new CELGenUserEvent('testing');
    }

    public function testGetName()
    {
        $this->assertEquals('CELGenUserEvent', $this->genUserEvent->getName());
    }

    public function testGetEventName()
    {
        $this->assertEquals('testing', $this->genUserEvent->getEventName());
    }

    public function testGetDataWithNoExtra()
    {
        $this->assertEquals('testing', $this->genUserEvent->getData());
    }

    public function testGetDataWithExtra()
    {
        $this->genUserEvent->setExtra('0123456789');
        $this->assertEquals('testing,0123456789', $this->genUserEvent->getData());
    }

    public function testToArray()
    {
        $this->genUserEvent->setExtra('0123456789');

        $expected = [
            'event_name' => 'testing',
            'extra' => '0123456789'
        ];

        $this->assertEquals($expected, $this->genUserEvent->toArray());
    }

    public function testToJson()
    {
        $this->genUserEvent->setExtra('0987654321');

        $expected = json_encode([
            'event_name' => 'testing',
            'extra' => '0987654321'
        ]);

        $this->assertEquals($expected, $this->genUserEvent->toJson());
    }
}