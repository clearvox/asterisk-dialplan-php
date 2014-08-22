<?php
namespace Clearvox\Asterisk\Dialplan\Line;

use Clearvox\Asterisk\Dialplan\Application\Realtime;

class SwitchLine implements LineInterface
{
    /**
     * @var \Clearvox\Asterisk\Dialplan\Application\Realtime
     */
    protected $application;

    public function __construct(Realtime $realtime)
    {
        $this->application = $realtime;
    }

    public function getPattern()
    {
        return '';
    }

    public function getPriority()
    {
        return '';
    }

    /**
     * @return \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    public function getApplication()
    {
        return $this->application;
    }

    public function toString()
    {
        return 'switch => ' . $this->application->toString();
    }
}