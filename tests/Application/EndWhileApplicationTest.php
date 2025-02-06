<?php

use Clearvox\Asterisk\Dialplan\Application\EndWhileApplication;
use PHPUnit\Framework\TestCase;

class EndWhileApplicationTest extends TestCase
{
    /**
     * @var EndWhileApplication
     */
    public $endWhile;

    public function setUp()
    {
        $this->endWhile = new EndWhileApplication();
    }

    public function testGetName()
    {
        $this->assertEquals('EndWhile', $this->endWhile->getName());
    }
}