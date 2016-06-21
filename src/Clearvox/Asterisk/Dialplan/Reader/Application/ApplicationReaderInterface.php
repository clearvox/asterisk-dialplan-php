<?php
namespace Clearvox\Asterisk\Dialplan\Reader\Application;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;

interface ApplicationReaderInterface
{
    /**
     * Return the regex string to match against.
     *
     * @return string
     */
    public function getMatchFormat();

    /**
     * Return the instance of the matching Application. The passed in matches are the matches
     * from the regex return above.
     *
     * @param array $matches
     * @return ApplicationInterface
     */
    public function getInstance($matches);
}