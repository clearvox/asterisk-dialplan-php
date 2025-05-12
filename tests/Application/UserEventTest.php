<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\UserEvent;
use PHPUnit\Framework\TestCase;

class UserEventTest extends TestCase
{
    /**
     * @var UserEvent
     */
    protected $userEvent;

    public function setUp(): void
    {
        $this->userEvent = new UserEvent('TestingEvent');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('UserEvent', $this->userEvent->getName());
    }

    public function testGetDataWithoutBody()
    {
        $this->assertEquals('TestingEvent', $this->userEvent->getData());
    }

    public function testGetDataWith1Body()
    {
        $this->userEvent->addBodyPart('Body', 'Value');

        $this->assertEquals('TestingEvent,Body: Value', $this->userEvent->getData());
    }

    public function testGetDataWithMultipleBody()
    {
        $this->userEvent
            ->addBodyPart('Part1', 'Part1Value')
            ->addBodyPart('Part2', 'Part2Value')
            ->addBodyPart('Part3', 'Part3Value');

        $this->assertEquals('TestingEvent,Part1: Part1Value,Part2: Part2Value,Part3: Part3Value', $this->userEvent->getData());
    }
}
 