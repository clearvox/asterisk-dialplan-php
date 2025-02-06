<?php
use Clearvox\Asterisk\Dialplan\Application\Stasis;
use PHPUnit\Framework\TestCase;

class StasisTest extends TestCase
{
    /**
     * @var Stasis
     */
    public $stasis;

    public function setUp()
    {
        $this->stasis = new Stasis('authentication');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('Stasis', $this->stasis->getName());
    }

    public function testGetCommandIsCorrect()
    {
        $this->assertEquals('authentication', $this->stasis->getCommand());
    }

    public function testGetDataWithNoArguments()
    {
        $this->assertEquals('authentication', $this->stasis->getData());
    }

    public function testGetDataWithArguments()
    {
        $this->stasis
            ->addArgument('12345')
            ->addArgument('abcde');

        $this->assertEquals('authentication,12345,abcde', $this->stasis->getData());
    }

}