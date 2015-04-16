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
     * @var \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    protected $application;

    public function __construct($pattern, $priority, ApplicationInterface $application)
    {
        $this->pattern     = $pattern;
        $this->priority    = $priority;
        $this->application = $application;
    }

    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get the application associated with this line.
     *
     * @return \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * Set the label for this line.
     *
     * @param string $label
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Get the label set for this line.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Turn this implemented Line into a string representation.
     *
     * @return string
     */
    public function toString()
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