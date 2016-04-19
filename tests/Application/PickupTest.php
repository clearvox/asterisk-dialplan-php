<?php

use Clearvox\Asterisk\Dialplan\Application\Pickup;

class PickupTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Pickup
     */
    public $pickup;

    public function setUp()
    {
        $this->pickup = new Pickup();
    }

    public function testGetName()
    {
        $this->assertEquals('Pickup', $this->pickup->getName());
    }

    public function testConstructorWithExtension()
    {
        $pickup = new Pickup('100@PICKUPMARK');
        $this->assertEquals(['100@PICKUPMARK'], $pickup->getExtensions());
    }

    public function testAddExtension()
    {
        $this->assertEquals([], $this->pickup->getExtensions());

        $this->pickup->addExtension('101@PICKUPMARK');

        $this->assertEquals(['101@PICKUPMARK'], $this->pickup->getExtensions());

        $this->pickup->addExtension('102@PICKUPMARK');

        $this->assertEquals(['101@PICKUPMARK', '102@PICKUPMARK'], $this->pickup->getExtensions());
    }

    public function testGetData()
    {
        $this->pickup
            ->addExtension('201@PICKUPMARK')
            ->addExtension('202@PICKUPMARK')
            ->addExtension('203@PICKUPMARK');

        $expected = "201@PICKUPMARK&202@PICKUPMARK&203@PICKUPMARK";

        $this->assertEquals($expected, $this->pickup->getData());
    }

    public function testToArray()
    {
        $this->pickup
            ->addExtension('301@PICKUPMARK')
            ->addExtension('302@PICKUPMARK');

        $expected = [
            'extensions' => ['301@PICKUPMARK', '302@PICKUPMARK']
        ];

        $this->assertEquals($expected, $this->pickup->toArray());
    }

    public function testToJson()
    {
        $this->pickup
            ->addExtension('301@PICKUPMARK')
            ->addExtension('302@PICKUPMARK');

        $expected = [
            'extensions' => ['301@PICKUPMARK', '302@PICKUPMARK']
        ];

        $this->assertEquals(json_encode($expected), $this->pickup->toJson());
    }

    public function testToString()
    {
        $this->pickup
            ->addExtension('500@internal')
            ->addExtension('500@external');

        $expected = 'Pickup(500@internal&500@external)';

        $this->assertEquals($expected, $this->pickup->toString());
    }
}