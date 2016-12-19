<?php

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Line\ExtenLine;
use Clearvox\Asterisk\Dialplan\Reader\Line\ExtenLineReader;

class ExtenLineReaderTest extends PHPUnit_Framework_TestCase
{
    public $testString = "exten => 100,1,NoOp(Hello world)";

    public function testMatchFormat()
    {
        $extenLineReader = new ExtenLineReader();
        $format = $extenLineReader->getMatchFormat();

        $preg = preg_match($format, $this->testString);
        $this->assertTrue($preg === 1);
    }

    public function testGetInstance()
    {
        $extenLineReader = new ExtenLineReader();

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $this->testString, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('100', $line->getPattern());
        $this->assertEquals('1', $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testAlternativePatternPossibilities()
    {
        $extenLineReader = new ExtenLineReader();

        $withSymbol  = 'exten => +3112345678,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $withSymbol, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('+3112345678', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testBasicPatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $basicNumber = 'exten => 3112345678,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $basicNumber, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('3112345678', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testWordPatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $exampleWord = 'exten => exampleword,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $exampleWord, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('exampleword', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testUnderscorePatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $exampleWord = 'exten => example_word,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $exampleWord, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('example_word', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testDashPatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $exampleWord = 'exten => example-word,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $exampleWord, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('example-word', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testDotPatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $exampleWord = 'exten => _XXX.,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $exampleWord, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('_XXX.', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testExclamationPatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $exampleWord = 'exten => _12345!,1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $exampleWord, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('_12345!', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }

    public function testSquareBracketsPatternPossibility()
    {
        $extenLineReader = new ExtenLineReader();

        $exampleWord = 'exten => _X[1-9],1,NoOp(Hello World)';

        $matches = [];
        preg_match($extenLineReader->getMatchFormat(), $exampleWord, $matches);

        $line = $extenLineReader->getInstance($matches);

        $this->assertInstanceOf(ExtenLine::class, $line);
        $this->assertEquals('_X[1-9]', $line->getPattern());
        $this->assertEquals(1, $line->getPriority());
        $this->assertInstanceOf(ApplicationInterface::class, $line->getApplication());
    }
}