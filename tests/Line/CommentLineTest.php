<?php
namespace Clearvox\Asterisk\Dialplan\Line;

class CommentLineTest extends \PHPUnit_Framework_TestCase
{
    public function testToString()
    {
        $comment = new CommentLine("Example Comment");

        $this->assertEquals("; Example Comment", $comment->toString());
    }
}