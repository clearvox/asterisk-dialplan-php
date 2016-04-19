<?php

use Clearvox\Asterisk\Dialplan\Application\PickupChan;

class PickupChanTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PickupChan
     */
    public $pickupChan;

    protected function setUp()
    {
        $this->pickupChan = new PickupChan('SIP/phone1');
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('PickupChan', $this->pickupChan->getName());
    }

    public function testGetChannelsIsCorrect()
    {
        $this->assertEquals(['SIP/phone1'], $this->pickupChan->getChannels());
    }

    public function testMultipleChannelsWithStringSecondParameter()
    {
        $pickupChan = new PickupChan('SIP/phone1', 'SIP/phone2');
        $this->assertEquals([
            'SIP/phone1',
            'SIP/phone2',
        ], $pickupChan->getChannels());
    }

    public function testMultipleChannelsWithArray()
    {
        $pickupChan = new PickupChan(['SIP/phone1', 'SIP/phone2', 'SIP/phone3']);
        $this->assertEquals(['SIP/phone1', 'SIP/phone2', 'SIP/phone3'], $pickupChan->getChannels());
    }

    public function testMultipleChannelsWithArraySecondParameter()
    {
        $pickupChan = new PickupChan(
            ['SIP/phone1', 'SIP/phone2', 'SIP/phone3'],
            ['SIP/phone4', 'SIP/phone5', 'SIP/phone1']
        );
        $this->assertEquals(
            ['SIP/phone1', 'SIP/phone2', 'SIP/phone3', 'SIP/phone4', 'SIP/phone5'],
            $pickupChan->getChannels()
        );
    }

    public function testOptions()
    {
        $this->pickupChan->setOptions('p');
        $this->assertEquals(['p'], $this->pickupChan->getOptions());
    }

    public function testOptionsWithArray()
    {
        $this->pickupChan->setOptions(['p', 'another', 'option(beep)']);
        $this->assertEquals(['p', 'another', 'option(beep)'], $this->pickupChan->getOptions());
    }

    public function testToArray()
    {
        $pickupChan = new PickupChan('SIP/phone1');
        $pickupChan->setOptions('p');

        $expected = [
            'channels' => ['SIP/phone1'],
            'options' => ['p']
        ];

        $this->assertEquals($expected, $pickupChan->toArray());
    }

    public function testToJson()
    {
        $pickupChan = new PickupChan('SIP/phone1');
        $pickupChan->setOptions('p');

        $expected = [
            'channels' => ['SIP/phone1'],
            'options' => ['p']
        ];

        $this->assertEquals(json_encode($expected), $pickupChan->toJson());
    }

    public function testSimpleToString()
    {
        $expected = 'PickupChan(SIP/phone1)';
        $this->assertEquals($expected, $this->pickupChan->toString());
    }

    public function testToString()
    {
        $pickupChan = new PickupChan('SIP/phone1', ['SIP/phone2', 'SIP/phone3']);
        $pickupChan->setOptions('p');

        $expected = 'PickupChan(SIP/phone1&SIP/phone2&SIP/phone3,p)';
        $this->assertEquals($expected, $pickupChan->toString());
    }
}