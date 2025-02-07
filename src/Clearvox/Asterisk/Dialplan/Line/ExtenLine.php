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
     * @var string
     */
    protected $label;

    /**
     * @var ApplicationInterface
     */
    protected $application;

    public function __construct($pattern, string $priority, ApplicationInterface $application)
    {
        $this->pattern     = $pattern;
        $this->priority    = $priority;
        $this->application = $application;
    }

    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority) {
        $this->priority = $priority;
    }

    /**
     * Get the application associated with this line.
     */
    public function getApplication(): ApplicationInterface
    {
        return $this->application;
    }

    /**
     * Set the label for this line.
     */
    public function setLabel(string $label): ExtenLine
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the label set for this line.
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * Turn this implemented Line into a string representation.
     */
    public function toString(): string
    {
        $label = '';

        if (isset($this->label)) {
            $label = '(' . $this->label . ')';
        }

        return 'exten => ' .
            $this->getPattern() .
            ',' . $this->getPriority() . $label .
            ',' . $this->application->toString();
    }
}