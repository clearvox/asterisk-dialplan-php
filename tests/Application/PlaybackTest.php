<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\Playback;
use PHPUnit\Framework\TestCase;

class PlaybackTest extends TestCase
{
    /**
     * @var Playback
     */
    public $playback;

    protected function setUp(): void
    {
        $this->playback = new Playback("agent-login");
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals("Playback", $this->playback->getName());
    }

    public function testWithOnlyRequiredParameters()
    {
        $this->assertEquals("Playback(agent-login)", $this->playback->toString());
    }

    public function testWithMoreSoundFiles()
    {
        $this->playback
            ->addFile('agent-logout')
            ->addFile('sound3');

        $this->assertEquals(
            "Playback(agent-login&agent-logout&sound3)",
            $this->playback->toString()
        );
    }

    public function testWithOnlyRequiredAndSkip()
    {
        $this->playback->setSkip(true);
        $this->assertEquals("Playback(agent-login,skip)", $this->playback->toString());
    }

    public function testWithOnlyRequiredAndNoAnswer()
    {
        $this->playback->setNoAnswer(true);
        $this->assertEquals("Playback(agent-login,noanswer)", $this->playback->toString());
    }

    public function testWithOnlyRequiredAndBothOptions()
    {
        $this->playback
            ->setSkip(true)
            ->setNoAnswer(true);

        $this->assertEquals("Playback(agent-login,skip,noanswer)", $this->playback->toString());
    }

    public function testWithMultipleAndSkip()
    {
        $this->playback
            ->addFile('agent-logout')
            ->addFile('sound3')
            ->setSkip(true);

        $this->assertEquals(
            "Playback(agent-login&agent-logout&sound3,skip)",
            $this->playback->toString()
        );
    }

    public function testWithMultipleAndNoAnswer()
    {
        $this->playback
            ->addFile('agent-logout')
            ->addFile('sound3')
            ->setNoAnswer(true);

        $this->assertEquals(
            "Playback(agent-login&agent-logout&sound3,noanswer)",
            $this->playback->toString()
        );
    }

    public function testWithMultipleAndBothOptions()
    {
        $this->playback
            ->addFile('agent-logout')
            ->addFile('sound3')
            ->setNoAnswer(true)
            ->setSkip(true);

        $this->assertEquals(
            "Playback(agent-login&agent-logout&sound3,skip,noanswer)",
            $this->playback->toString()
        );
    }
}