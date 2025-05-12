<?php

namespace Application;

use Clearvox\Asterisk\Dialplan\Application\Record;
use PHPUnit\Framework\TestCase;

class RecordTest extends TestCase
{
    /**
     * @var Record
     */
    public $record;

    protected function setUp(): void
    {
        $this->record = new Record("/tmp/hello-world.wav");
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals("Record", $this->record->getName());
    }

    public function testWithOnlyRequiredParameters()
    {
        $this->assertEquals("Record(/tmp/hello-world.wav)", $this->record->toString());
    }

    public function testWithSilenceOnly()
    {
        $this->record->setSilence(5);

        $this->assertEquals("Record(/tmp/hello-world.wav,5)", $this->record->toString());
    }

    public function testWithMaxDurationOnly()
    {
        $this->record->setMaxDuration(10);

        $this->assertEquals("Record(/tmp/hello-world.wav,,10)", $this->record->toString());
    }

    public function testWithOptionsOnly()
    {
        $this->record->setOptions(['a', 'q', 's']);

        $this->assertEquals("Record(/tmp/hello-world.wav,,,aqs)", $this->record->toString());
    }

    public function testWithSilenceAndMaxDuration()
    {
        $this->record->setSilence(5);
        $this->record->setMaxDuration(10);

        $this->assertEquals("Record(/tmp/hello-world.wav,5,10)", $this->record->toString());
    }

    public function testWithSilenceAndOptions()
    {
        $this->record->setSilence(5);
        $this->record->setOptions(['a', 'q', 's']);

        $this->assertEquals("Record(/tmp/hello-world.wav,5,,aqs)", $this->record->toString());
    }

    public function testWithMaxDurationAndOptions()
    {
        $this->record->setMaxDuration(10);
        $this->record->setOptions(['a', 'q', 's']);

        $this->assertEquals("Record(/tmp/hello-world.wav,,10,aqs)", $this->record->toString());
    }

    public function testWithSilenceAndMaxDurationAndOptions()
    {
        $this->record->setSilence(5);
        $this->record->setMaxDuration(10);
        $this->record->setOptions(['a', 'q', 's']);

        $this->assertEquals("Record(/tmp/hello-world.wav,5,10,aqs)", $this->record->toString());
    }
}