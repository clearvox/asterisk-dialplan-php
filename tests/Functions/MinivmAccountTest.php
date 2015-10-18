<?php
use Clearvox\Asterisk\Dialplan\Functions\MinivmAccount;

class MinivmAccountTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MinivmAccount
     */
    public $minivmAccount;

    public function setUp()
    {
        $this->minivmAccount = new MinivmAccount('test@example.com');
    }

    public function testToString()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:hasaccount)',
            $this->minivmAccount->toString()
        );
    }

    public function testMagicMethodString()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:hasaccount)',
            (string)$this->minivmAccount
        );
    }

    public function testRequestHasAccount()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:hasaccount)',
            $this->minivmAccount->requestHasAccount()
        );
    }

    public function testRequestFullName()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:fullname)',
            $this->minivmAccount->requestFullName()
        );
    }

    public function testRequestEmail()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:email)',
            $this->minivmAccount->requestEmail()
        );
    }

    public function testRequestETemplate()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:etemplate)',
            $this->minivmAccount->requestETemplate()
        );
    }

    public function testRequestPTemplate()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:ptemplate)',
            $this->minivmAccount->requestPTemplate()
        );
    }

    public function testRequestAccountCode()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:accountcode)',
            $this->minivmAccount->requestAccountCode()
        );
    }

    public function testRequestPath()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:path)',
            $this->minivmAccount->requestPath()
        );
    }

    public function testRequestPincode()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:pincode)',
            $this->minivmAccount->requestPinCode()
        );
    }

    public function testRequestTimeZone()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:timezone)',
            $this->minivmAccount->requestTimeZone()
        );
    }

    public function testRequestLanguage()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:language)',
            $this->minivmAccount->requestLanguage()
        );
    }

    public function testRequestCustom()
    {
        $this->assertEquals(
            'MINIVMACCOUNT(test@example.com:customerclass)',
            $this->minivmAccount->requestCustom('customerclass')
        );
    }


}