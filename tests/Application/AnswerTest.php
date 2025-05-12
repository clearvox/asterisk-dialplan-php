<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\Answer;
use PHPUnit\Framework\TestCase;

class AnswerTest extends TestCase
{
    /**
     * @var Answer
     */
    protected $answer;

    public function setUp(): void
    {
        $this->answer = new Answer(100);
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('Answer', $this->answer->getName());
    }

    public function testGetDelayIsCorrect()
    {
        $this->assertEquals(100, $this->answer->getDelay());
    }

    public function testGetDataIsCorrect()
    {
        $this->assertEquals(100, $this->answer->getData());
    }
}