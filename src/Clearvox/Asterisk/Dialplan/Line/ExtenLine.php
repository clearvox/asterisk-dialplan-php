<?php
namespace Clearvox\Asterisk\Dialplan\Line;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;

class ExtenLine implements LineInterface
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var string
     */
    protected $priority;

    /**
     * @var \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    protected $application;

    public function __construct($pattern, $priority, ApplicationInterface $application)
    {
        $this->pattern     = $pattern;
        $this->priority    = $priority;
        $this->application = $application;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function getApplication()
    {
        return $this->application;
    }

    public function toString()
    {
        return 'exten => ' .
            $this->getPattern() .
            ',' . $this->getPriority() .
            ',' . $this->application->toString();
    }
}