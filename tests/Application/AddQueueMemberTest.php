<?php

use Clearvox\Asterisk\Dialplan\Application\AddQueueMember;
use PHPUnit\Framework\TestCase;

class AddQueueMemberTest extends TestCase
{
    /**
     * @var AddQueueMember
     */
    protected $queueMember;

    public function setUp()
    {
        $this->queueMember = new AddQueueMember('support');
    }

    public function testGetName()
    {
        $this->assertEquals('AddQueueMember', $this->queueMember->getName());
    }

    public function testGetQueueName()
    {
        $this->assertEquals('support', $this->queueMember->getQueueName());
    }

    public function testGetDataWithNoArguments()
    {
        $this->assertEquals('support', $this->queueMember->getData());
    }

    public function testGetDataWithInterface()
    {
        $this->queueMember
            ->setInterface('SIP/3000');

        $this->assertEquals('support,SIP/3000', $this->queueMember->getData());
    }

    public function testGetDataWithInterfacePenalty()
    {
        $this->queueMember
            ->setInterface('SIP/3000')
            ->setPenalty(10);

        $this->assertEquals('support,SIP/3000,10', $this->queueMember->getData());
    }

    public function testGetDataWithInterfacePenaltyOptions()
    {
        $this->queueMember
            ->setInterface('SIP/3000')
            ->setPenalty(10)
            ->setOptions(['j']);

        $this->assertEquals('support,SIP/3000,10,j', $this->queueMember->getData());
    }

    public function testGetDataWithInterfacePenaltyMemberName()
    {
        $this->queueMember
            ->setInterface('SIP/3000')
            ->setPenalty(10)
            ->setMemberName('john');

        $this->assertEquals('support,SIP/3000,10,,john', $this->queueMember->getData());
    }

    public function testGetDataWithInterfacePenaltyMemberNameStateInterface()
    {
        $this->queueMember
            ->setInterface('SIP/3000')
            ->setPenalty(10)
            ->setMemberName('james')
            ->setStateInterface('SIP/1000');

        $this->assertEquals('support,SIP/3000,10,,james,SIP/1000', $this->queueMember->getData());
    }

    public function testGetDataOnlyStateInterface()
    {
        $this->queueMember
            ->setStateInterface('SIP/1000');

        $this->assertEquals('support,,,,,SIP/1000', $this->queueMember->getData());
    }

    public function testToArray()
    {
        $this->queueMember
            ->setInterface('SIP/3000')
            ->setPenalty(10)
            ->setOptions(['j'])
            ->setMemberName('james')
            ->setStateInterface('SIP/1000');

        $expected = [
            'name' => 'support',
            'interface' => 'SIP/3000',
            'penalty' => 10,
            'options' => ['j'],
            'member_name' => 'james',
            'state_interface' => 'SIP/1000'
        ];

        $this->assertEquals($expected, $this->queueMember->toArray());
    }

    public function testToJson()
    {
        $this->queueMember
            ->setInterface('SIP/3000')
            ->setPenalty(10)
            ->setOptions(['j'])
            ->setMemberName('james')
            ->setStateInterface('SIP/1000');

        $expected = json_encode([
            'name' => 'support',
            'interface' => 'SIP/3000',
            'penalty' => 10,
            'options' => ['j'],
            'member_name' => 'james',
            'state_interface' => 'SIP/1000'
        ]);

        $this->assertEquals($expected, $this->queueMember->toJson());
    }
}