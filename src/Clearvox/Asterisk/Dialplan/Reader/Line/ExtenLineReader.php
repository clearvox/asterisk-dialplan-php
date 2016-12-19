<?php
namespace Clearvox\Asterisk\Dialplan\Reader\Line;

use Clearvox\Asterisk\Dialplan\Line\ExtenLine;
use Clearvox\Asterisk\Dialplan\Line\LineInterface;
use Clearvox\Asterisk\Dialplan\Reader\Application\ApplicationReaderInterface;
use Clearvox\Asterisk\Dialplan\Reader\Application\HasApplicationTrait;

class ExtenLineReader implements LineReaderInterface
{
    use HasApplicationTrait;

    /**
     * @var ApplicationReaderInterface[]
     */
    protected $applications;

    /**
     * @param ApplicationReaderInterface[] $applications
     */
    public function __construct(
        array $applications = []
    ) {
        $this->applications = $applications;
    }

    /**
     * Should return the regex string to match the line against this line instance.
     *
     * @return string
     */
    public function getMatchFormat()
    {
        return "/^exten\s?=>\s?([A-Za-z0-9\-+_]+),([0-9]+)(\(?.+\))?,(.+)/";
    }

    /**
     * Return the instance of the line interface. Will be given the matches from
     * the match format above.
     *
     * @param array $matches
     * @return LineInterface
     */
    public function getInstance($matches)
    {
        $application = $this->findApplication($matches[4], $this->applications);
        $extenLine = new ExtenLine($matches[1], $matches[2], $application);

        if(!empty($matches[3])) {
            $extenLine->setLabel(str_replace(['(', ')'], '', $matches[3]));
        }

        return $extenLine;
    }
}