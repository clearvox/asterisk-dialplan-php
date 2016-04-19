<?php
namespace Clearvox\Asterisk\Dialplan\Reader\Lines;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Line\ExtenLine;

class ExtenLineReader
{
    public function getMatchFormat()
    {
        return '/^exten\s?=>\s?([A-Za-z0-9]+),([1-9n]+),([\'"A-Za-z0-9\(\) ]+)/';
    }

    public function getInstance($matches, ApplicationInterface $application)
    {
        return new ExtenLine($matches[0], $matches[1], $application);
    }
}