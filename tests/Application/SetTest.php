<?php


use Clearvox\Asterisk\Dialplan\Application\Set;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
    public function testGetName()
    {
        $set = new Set('VARIABLE', 'TESTING');
        $this->assertEquals('Set', $set->getName());
    }

    public function testSimpleVariableSet()
    {
        $set = new Set('VARIABLENAME', '12345');
        $this->assertEquals('VARIABLENAME=12345', $set->getData());
    }

    public function testInheritVariable()
    {
        $set = new Set('VARIABLENAME', '123456');
        $set->inherit();

        $this->assertEquals('_VARIABLENAME=123456', $set->getData());
    }

    public function testInheritChildVariable()
    {
        $set = new Set('VARIABLENAME', '54321');
        $set->inheritChildren();

        $this->assertEquals('__VARIABLENAME=54321', $set->getData());
    }
}