<?php
use Clearvox\Asterisk\Dialplan\Application\AGI;
use PHPUnit\Framework\TestCase;

class AGITest extends TestCase
{
    /**
     * @var AGI
     */
    public $agi;

    public function setUp()
    {
        $this->agi = new AGI('agi://127.0.0.7:6565/exampleScript');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('AGI', $this->agi->getName());
    }

    public function testGetCommandIsCorrect()
    {
        $this->assertEquals('agi://127.0.0.7:6565/exampleScript', $this->agi->getCommand());
    }

    public function testGetDataWithNoArguments()
    {
        $this->assertEquals('agi://127.0.0.7:6565/exampleScript', $this->agi->getData());
    }

    public function testGetDataWithArguments()
    {
        $this->agi
            ->addArgument('12345')
            ->addArgument('abcde');

        $this->assertEquals('agi://127.0.0.7:6565/exampleScript,12345,abcde', $this->agi->getData());
    }

}