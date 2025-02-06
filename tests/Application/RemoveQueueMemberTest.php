<?php

use Clearvox\Asterisk\Dialplan\Application\RemoveQueueMember;
use PHPUnit\Framework\TestCase;

class RemoveQueueMemberTest extends TestCase
{
    /**
     * @var RemoveQueueMember
     */
    public $removeMember;

    public function setUp()
    {
        $this->removeMember = new RemoveQueueMember('support');
    }

    public function testGetName()
    {
        $this->assertEquals('RemoveQueueMember', $this->removeMember->getName());
    }

    public function testGetQueueName()
    {
        $this->assertEquals('support', $this->removeMember->getQueueName());
    }

    public function testGetDataNoArguments()
    {
        $this->assertEquals('support', $this->removeMember->getData());
    }

    public function testGetDataWithInterface()
    {
        $this->removeMember
            ->setInterface('SIP/1000');

        $this->assertEquals('support,SIP/1000', $this->removeMember->getData());
    }

    public function testToArray()
    {
        $this->removeMember
            ->setInterface('SIP/1000');

        $expected = [
            'name' => 'support',
            'interface' => 'SIP/1000'
        ];

        $this->assertEquals($expected, $this->removeMember->toArray());
    }

    public function testToJson()
    {
        $this->removeMember
            ->setInterface('SIP/1000');

        $expected = json_encode([
            'name' => 'support',
            'interface' => 'SIP/1000'
        ]);

        $this->assertEquals($expected, $this->removeMember->toJson());
    }

}