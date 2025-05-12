<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\BackGround;
use PHPUnit\Framework\TestCase;

class BackGroundTest extends TestCase
{
    /**
     * @var BackGround
     */
    public $background;

    public function setUp(): void
    {
        $this->background = new BackGround('beep');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('BackGround', $this->background->getName());
    }

    public function testGetDataIsCorrect()
    {
        $this->assertEquals('beep', $this->background->getData());

        $this->background->addFile('vm-password');
        $this->assertEquals('beep&vm-password', $this->background->getData());

        $this->background->setContext('incoming');
        $this->assertEquals('beep&vm-password,,,incoming', $this->background->getData());

        $this->background->setLangOverride('en');
        $this->assertEquals('beep&vm-password,,en,incoming', $this->background->getData());

        $this->background->setNoAnswer(true);
        $this->assertEquals('beep&vm-password,n,en,incoming', $this->background->getData());

        $this->background
            ->setSkip(true)
            ->setOnlyMatch(true);

        $this->assertEquals('beep&vm-password,snm,en,incoming', $this->background->getData());
    }

    public function testGetArrayAndJson()
    {
        $expected = [
            'filename'      => 'beep',
            'other_files'   => [],
            'skip'          => false,
            'no_answer'     => false,
            'only_match'    => true,
            'lang_override' => 'en',
            'context'       => 'incoming'
        ];

        $this->background
            ->setContext('incoming')
            ->setLangOverride('en')
            ->setSkip(false)
            ->setNoAnswer(false)
            ->setOnlyMatch(true);

        $this->assertEquals($expected, $this->background->toArray());
        $this->assertEquals(json_encode($expected), $this->background->toJson());
    }
}