<?php

use Clearvox\Asterisk\Dialplan\Application\Authenticate;
use PHPUnit\Framework\TestCase;

class AuthenticateTest extends TestCase
{
    /**
     * @var Authenticate
     */
    protected $authenticate;

    public function setUp()
    {
        $this->authenticate = new Authenticate('1234');
    }

    public function testNameIsCorrect()
    {
        $this->assertEquals('Authenticate', $this->authenticate->getName());
    }

    public function testPasswordIsCorrect()
    {
        $this->assertEquals('1234', $this->authenticate->getPassword());
    }

    public function testGetDataIsCorrect()
    {
        $this->assertEquals('1234', $this->authenticate->getData());
    }

    public function testGetDataWithParameters()
    {
        $this->authenticate->setMaxDigits(5);
        $this->assertEquals('1234,,5', $this->authenticate->getData());

        $this->authenticate->setOptions(['a', 'm']);
        $this->assertEquals('1234,am,5', $this->authenticate->getData());

        $this->authenticate->setPrompt(true);
        $this->assertEquals('1234,am,5,1', $this->authenticate->getData());
    }

    public function testDataWithOnlyOptions()
    {
        $this->authenticate->setOptions(['a', 'm']);
        $this->assertEquals('1234,am', $this->authenticate->getData());
    }

    public function testDataWithOnlyMaxDigits()
    {
        $this->authenticate->setMaxDigits(10);
        $this->assertEquals('1234,,10', $this->authenticate->getData());
    }

    public function testDataWithOnlyPrompt()
    {
        $this->authenticate->setPrompt(true);
        $this->assertEquals('1234,,,1', $this->authenticate->getData());
    }
}