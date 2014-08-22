<?php
namespace Clearvox\Asterisk\Dialplan\Line;

class IncludeLine implements LineInterface
{
    /**
     * @var string
     */
    protected $context;

    public function __construct($context)
    {
        $this->context = $context;
    }

    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPattern()
    {
        return '';
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPriority()
    {
        return '';
    }

    /**
     * Get the application associated with this line.
     *
     * @return \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    public function getApplication()
    {
        return null;
    }

    /**
     * Turn this implemented Line into a string representation.
     *
     * @return string
     */
    public function toString()
    {
        return 'include => ' . $this->context;
    }

}