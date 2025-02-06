<?php
namespace Clearvox\Asterisk\Dialplan\Line;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;

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
     */
    public function getPattern(): ?string
    {
        return '';
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPriority(): ?string
    {
        return '';
    }

    /**
     * Get the application associated with this line.
     *
     * @return ApplicationInterface
     */
    public function getApplication(): ?ApplicationInterface
    {
        return null;
    }

    /**
     * Turn this implemented Line into a string representation.
     */
    public function toString(): string
    {
        return 'include => ' . $this->context;
    }

}