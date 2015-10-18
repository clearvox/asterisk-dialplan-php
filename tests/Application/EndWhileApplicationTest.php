<?php

use Clearvox\Asterisk\Dialplan\Application\EndWhileApplication;

class EndWhileApplicationTest extends PHPUnit_Framework_TestCase
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