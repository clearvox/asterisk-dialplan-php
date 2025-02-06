<?php

use Clearvox\Asterisk\Dialplan\Application\Go;
use PHPUnit\Framework\TestCase;

class GoTest extends TestCase
{
    public function testGetNameIsCorrect()
    {
        $goto = new Go(1);
        $this->assertEquals('Goto', $goto->getName());
    }

    public function testJustPriorityData()
    {
        $goto = new Go(1);
        $this->assertEquals('1', $goto->getData());
    }

    public function testPriorityAndExtensionsData()
    {
        $goto = new Go(1,100);
        $this->assertEquals('100,1', $goto->getData());
    }

    public function testPriorityExtensionAndContextData()
    {
        $goto = new Go(1,100,'telephones');
        $this->assertEquals('telephones,100,1', $goto->getData());
    }

    public function testString()
    {
        $goto = new Go(1,'${EXTEN}', 'telephones');
        $this->assertEquals('Goto(telephones,${EXTEN},1)', $goto->toString());
    }
}
 