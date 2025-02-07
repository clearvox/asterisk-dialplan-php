<?php
namespace Clearvox\Asterisk\Dialplan\Line;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;

interface LineInterface
{
    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPattern(): ?string;

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPriority(): ?string;

    /**
     * Get the application associated with this line.
     */
    public function getApplication(): ?ApplicationInterface;

    /**
     * Turn this implemented Line into a string representation.
     */
    public function toString(): string;
}