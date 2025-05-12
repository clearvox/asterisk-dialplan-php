<?php

namespace Line;

use Clearvox\Asterisk\Dialplan\Line\CommentLine;
use PHPUnit\Framework\TestCase;

class CommentLineTest extends TestCase
{
    public function testToString()
    {
        $comment = new CommentLine("Example Comment");

        $this->assertEquals("; Example Comment", $comment->toString());
    }
}