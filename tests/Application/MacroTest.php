<?php
use Clearvox\Asterisk\Dialplan\Application\Macro;
use PHPUnit\Framework\TestCase;

class MacroTest extends TestCase
{
    /**
     * @var Macro
     */
    public $macro;

    public function setUp()
    {
        $this->macro = new Macro('Testing');
    }

    public function testGetNameIsCorrect()
    {
        $this->assertEquals('Macro', $this->macro->getName());
    }

    public function testGetMacroNameIsCorrect()
    {
        $this->assertEquals('Testing', $this->macro->getMacroName());
    }

    public function testGetDataWithNoArguments()
    {
        $this->assertEquals('Testing', $this->macro->getData());
    }

    public function testGetDataWithArguments()
    {
        $this->macro
            ->addArgument('1234')
            ->addArgument('5678')
            ->addArgument('90AB');

        $this->assertEquals('Testing,1234,5678,90AB', $this->macro->getData());
    }
}