<?php

use Clearvox\Asterisk\Dialplan\Application\WhileApplication;
use PHPUnit\Framework\TestCase;

class WhileApplicationTest extends TestCase
{
    /**
     * @var WhileApplication
     */
    public $while;

    public function setUp()
    {
        $this->while = new WhileApplication('$[1=1]');
    }

    public function testGetName()
    {
        $this->assertEquals('While', $this->while->getName());
    }

    public function testGetExpression()
    {
        $this->assertEquals('$[1=1]', $this->while->getExpression());
    }

    public function testGetData()
    {
        $this->assertEquals('$[1=1]', $this->while->getData());
    }

    public function testToArray()
    {
        $expected = ['expression' => '$[1=1]'];

        $this->assertEquals($expected, $this->while->toArray());
    }

    public function testToJson()
    {
        $expected = json_encode(['expression' => '$[1=1]']);
        $this->assertEquals($expected, $this->while->toJson());
    }
}