<?php
namespace Clearvox\Asterisk\Dialplan\Line;

interface LineInterface
{
    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPattern();

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPriority();

    /**
     * Get the application associated with this line.
     *
     * @return \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    public function getApplication();

    /**
     * Turn this implemented Line into a string representation.
     *
     * @return string
     */
    public function toString();
}