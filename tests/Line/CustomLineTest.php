<?php
use Clearvox\Asterisk\Dialplan\Line\CustomLine;

class CustomLineTest extends PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $custom = new CustomLine("#include /example/path/*.conf");
        $this->assertEquals("#include /example/path/*.conf", $custom->toString());
    }
}