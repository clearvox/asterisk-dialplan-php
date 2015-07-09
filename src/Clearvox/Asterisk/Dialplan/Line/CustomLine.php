<?php
namespace Clearvox\Asterisk\Dialplan\Line;

class CustomLine implements LineInterface
{
    /**
     * @var string
     */
    protected $line;

    /**
     * Set any custom line to use in the dialplan. Can be used, for example
     * to reference a wildcard path with #include. (different from the asterisk
     * line include =>)
     *
     * @param string $line
     */
    public function __construct($line)
    {
        $this->line = $line;
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
        return $this->line;
    }

}