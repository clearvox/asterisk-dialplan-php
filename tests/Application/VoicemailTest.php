<?php

use Clearvox\Asterisk\Dialplan\Application\Voicemail;
use PHPUnit\Framework\TestCase;

class VoicemailTest extends TestCase
{
    /**
     * @var Voicemail
     */
    public $voicemail;

    public function setUp()
    {
        $this->voicemail = new Voicemail('100', 'default', ['b', 'u']);
    }

    public function testName()
    {
        $this->assertEquals('Voicemail', $this->voicemail->getName());
    }

    public function testData()
    {
        $this->assertEquals('100@default,bu', $this->voicemail->getData());
    }

    public function testDataWithoutContextAndOneMailboxNoOptions()
    {
        $voicemail = new Voicemail('100');
        $this->assertEquals('100', $voicemail->getData());
    }

    public function testDataWithContextNoOptions()
    {
        $voicemail = new Voicemail('100', 'default');
        $this->assertEquals('100@default', $voicemail->getData());
    }

    public function testDataWithoutContextAndOptions()
    {
        $voicemail = new Voicemail('100', null, ['b', 'u']);
        $this->assertEquals('100,bu', $voicemail->getData());
    }

    public function testAddMailbox()
    {
        $this->voicemail->addMailbox('200', 'another_context');
        $this->assertEquals('100@default&200@another_context,bu', $this->voicemail->getData());
    }

    public function testGetMailboxes()
    {
        $voicemail = new Voicemail('100');
        $voicemail->addMailbox('200', 'example');

        $expected = [['mailbox' => '100', 'context' => null], ['mailbox' => '200', 'context' => 'example']];
        $this->assertEquals($expected, $voicemail->getMailboxes());
    }

    public function testToArray()
    {
        $expected = [
            'mailboxes' => [
                ['mailbox' => '100', 'context' => 'default']
            ],
            'options' => ['b', 'u']
        ];

        $this->assertEquals($expected, $this->voicemail->toArray());
    }
}