<?php

use Clearvox\Asterisk\Dialplan\Application\MinivmMWI;

class MinivmMWITest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MinivmMWI
     */
    public $minivmMWI;

    public function setUp()
    {
        $this->minivmMWI = new MinivmMWI('example@host.com', 0, 1, 2);
    }

    public function testGetName()
    {
        $this->assertEquals('MinivmMWI', $this->minivmMWI->getName());
    }

    public function testGetUrgent()
    {
        $expected = 0;
        $this->assertEquals($expected, $this->minivmMWI->getUrgent());
    }

    public function testGetNew()
    {
        $expected = 1;
        $this->assertEquals($expected, $this->minivmMWI->getNew());
    }

    public function testGetOld()
    {
        $expected = 2;
        $this->assertEquals($expected, $this->minivmMWI->getOld());
    }

    public function testGetData()
    {
        $expected = 'example@host.com,0,1,2';
        $this->assertEquals($expected, $this->minivmMWI->getData());
    }

    public function testToArray()
    {
        $expected = ['account' => 'example@host.com', 'urgent' => 0, 'new' => 1, 'old' => 2];
        $this->assertEquals($expected, $this->minivmMWI->toArray());
    }

    public function testToString()
    {
        $expected = "MinivmMWI(example@host.com,0,1,2)";
        $this->assertEquals($expected, $this->minivmMWI->toString());
    }

    public function testToJson()
    {
        $expected = json_encode(['account' => 'example@host.com', 'urgent' => 0, 'new' => 1, 'old' => 2]);
        $this->assertEquals($expected, $this->minivmMWI->toJson());
    }
}