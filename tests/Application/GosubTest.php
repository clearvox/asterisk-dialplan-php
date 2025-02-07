<?php

use Clearvox\Asterisk\Dialplan\Application\Gosub;

class GosubTest extends \PHPUnit\Framework\TestCase
{
    public $goSub;

    public function testGetName()
    {
        $goSub = new Gosub(1);
        $this->assertEquals('Gosub', $goSub->getName());
    }

    public function testGetDataPriority()
    {
        $goSub = new Gosub(1);
        $this->assertEquals('1', $goSub->getData());
    }

    public function testGetDataPriorityContext()
    {
        $goSub = new Gosub(1, 'example_context');
        $this->assertEquals('example_context,1', $goSub->getData());
    }

    public function testGetDataPriorityContextExten()
    {
        $goSub = new Gosub(1, 'example_context', 100);
        $this->assertEquals('example_context,100,1', $goSub->getData());
    }

    public function testGetDataPriorityContextExtenArguments()
    {
        $goSub = new Gosub(1, 'example_context', 100, [
            '${EXAMPLE_ARGUMENT}',
            '67890'
        ]);

        $this->assertEquals('example_context,100,1(${EXAMPLE_ARGUMENT},67890)', $goSub->getData());
    }

    public function testGetDataArguments()
    {
        $goSub = new Gosub(1,null,null,[
            '12345',
            '09876'
        ]);

        $this->assertEquals('1(12345,09876)', $goSub->getData());
    }
}