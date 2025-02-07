<?php

use Clearvox\Asterisk\Dialplan\Application\MinivmGreet;
use PHPUnit\Framework\TestCase;

class MinivmGreetTest extends TestCase
{
    /**
     * @var MinivmGreet
     */
    public $minivmGreet;

    public function setUp()
    {
        $this->minivmGreet = new MinivmGreet('example@test.com', ['s']);
    }

    public function testGetName()
    {
        $this->assertEquals('MinivmGreet', $this->minivmGreet->getName());
    }

    public function testGetOptions()
    {
        $expected = ['s'];
        $this->assertEquals($expected, $this->minivmGreet->getOptions());
    }

    public function testGetData()
    {
        $expected = 'example@test.com,s';
        $this->assertEquals($expected, $this->minivmGreet->getData());
    }

    public function testToArray()
    {
        $expected = ['account' => 'example@test.com', 'options' => ['s']];
        $this->assertEquals($expected, $this->minivmGreet->toArray());
    }

    public function testToJson()
    {
        $expected = json_encode(['account' => 'example@test.com', 'options' => ['s']]);
        $this->assertEquals($expected, $this->minivmGreet->toJson());
    }
}