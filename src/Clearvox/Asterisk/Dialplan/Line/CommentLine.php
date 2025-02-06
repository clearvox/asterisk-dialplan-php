<?php
namespace Clearvox\Asterisk\Dialplan\Line;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;

class CommentLine implements LineInterface
{
    protected $comment;

    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPattern(): string
    {
        return '';
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPriority(): ?string
    {
        return null;
    }

    /**
     * Get the application associated with this line.
     */
    public function getApplication(): ?ApplicationInterface
    {
        return null;
    }

    /**
     * Turn this implemented Line into a string representation.
     */
    public function toString(): string
    {
        return "; $this->comment";
    }
}