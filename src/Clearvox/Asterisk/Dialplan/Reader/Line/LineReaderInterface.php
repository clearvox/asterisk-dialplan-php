<?php
namespace Clearvox\Asterisk\Dialplan\Reader\Line;

use Clearvox\Asterisk\Dialplan\Line\LineInterface;

interface LineReaderInterface
{
    /**
     * Should return the regex string to match the line against this line instance.
     *
     * @return string
     */
    public function getMatchFormat();

    /**
     * Return the instance of the line interface. Will be given the matches from
     * the match format above.
     *
     * @param array $matches
     * @return LineInterface
     */
    public function getInstance($matches);
}