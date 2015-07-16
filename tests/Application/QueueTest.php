<?php

use Clearvox\Asterisk\Dialplan\Application\Queue;

class QueueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Queue
     */
    public $queue;

    public function setUp()
    {
        $this->queue = new Queue('testing');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('Queue', $this->queue->getName());
    }

    public function testGetQueueNameIsCorrect()
    {
        $this->assertEquals('testing', $this->queue->getQueueName());
    }

    public function testGetDataWithNoArguments()
    {
        $this->assertEquals('testing', $this->queue->getData());
    }

    public function testGetDataWithOptions()
    {
        $this->queue->setOptions([
            'c',
            'F(another_context^100^1)'
        ]);

        $this->assertEquals('testing,cF(another_context^100^1)', $this->queue->getData());
    }

    public function testGetDataWithOptionsUrl()
    {
        $this->queue
            ->setOptions(
                [
                    'c',
                    'F(another_context^100^1)',
                    'r'
                ]
            )
            ->setURL('http://test.com');

        $this->assertEquals('testing,cF(another_context^100^1)r,http://test.com', $this->queue->getData());
    }

    public function testGetDataWithOptionsURLAnnounce()
    {
        $this->queue
            ->setOptions(['c', 'r'])
            ->setURL('http://test.com')
            ->setAnnounceOverride('beep');

        $this->assertEquals(
            'testing,cr,http://test.com,beep',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOptionsURLAnnounceTimeout()
    {
        $this->queue
            ->setOptions(['c', 'r', 'R'])
            ->setURL('http://example.com')
            ->setAnnounceOverride('beeperr')
            ->setTimeout(10);

        $this->assertEquals(
            'testing,crR,http://example.com,beeperr,10',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOptionsURLAnnounceTimeoutAGI()
    {
        $this->queue
            ->setOptions(['c', 'r'])
            ->setURL('http://test.com')
            ->setAnnounceOverride('beep')
            ->setTimeout(10)
            ->setAGI('example-agi');

        $this->assertEquals(
            'testing,cr,http://test.com,beep,10,example-agi',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOptionsURLAnnounceTimeoutAGIMacro()
    {
        $this->queue
            ->setOptions(['c', 'R', 'r'])
            ->setURL('http://test.com')
            ->setAnnounceOverride('beeperr')
            ->setTimeout(15)
            ->setAGI('example-agi')
            ->setMacro('example');

        $this->assertEquals(
            'testing,cRr,http://test.com,beeperr,15,example-agi,example',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOptionsURLAnnounceTimeoutAGIMacroGoSub()
    {
        $this->queue
            ->setOptions(['c', 'r'])
            ->setURL('http://test.com')
            ->setAnnounceOverride('beep')
            ->setTimeout(10)
            ->setAGI('agi-example')
            ->setMacro('another')
            ->setGoSub('example-gosub');

        $this->assertEquals(
            'testing,cr,http://test.com,beep,10,agi-example,another,example-gosub',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOptionsURLAnnounceTimeoutAGIMacroGoSubRule()
    {
        $this->queue
            ->setOptions(['c', 'r'])
            ->setURL('http://test.com')
            ->setAnnounceOverride('beep')
            ->setTimeout(10)
            ->setAGI('agi-example')
            ->setMacro('another')
            ->setGoSub('example-gosub')
            ->setRule('override-rule');

        $this->assertEquals(
            'testing,cr,http://test.com,beep,10,agi-example,another,example-gosub,override-rule',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOptionsURLAnnounceTimeoutAGIMacroGoSubRulePosition()
    {
        $this->queue
            ->setOptions(['c', 'r'])
            ->setURL('http://test.com')
            ->setAnnounceOverride('beep')
            ->setTimeout(10)
            ->setAGI('agi-example')
            ->setMacro('another')
            ->setGoSub('example-gosub')
            ->setRule('override-rule')
            ->setPosition(3);

        $this->assertEquals(
            'testing,cr,http://test.com,beep,10,agi-example,another,example-gosub,override-rule,3',
            $this->queue->getData()
        );
    }

    public function testGetDataWithOnlyPosition()
    {
        $this->queue
            ->setPosition(2);

        $this->assertEquals(
            'testing,,,,,,,,,2',
            $this->queue->getData()
        );
    }
}