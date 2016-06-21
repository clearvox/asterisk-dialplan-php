<?php
namespace Clearvox\Asterisk\Dialplan\Reader\Application;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Application\NoOp;

class NoOpReader implements ApplicationReaderInterface
{
    /**
     * Return the regex string to match against.
     *
     * @return string
     */
    public function getMatchFormat()
    {
        return "/NoOp\((.+)\)/";
    }

    /**
     * Return the instance of the matching Application. The passed in matches are the matches
     * from the regex return above.
     *
     * @param array $matches
     * @return ApplicationInterface
     */
    public function getInstance($matches)
    {
        return new NoOp($matches[1]);
    }
}