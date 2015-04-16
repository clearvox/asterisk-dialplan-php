<?php
namespace Clearvox\Asterisk\Dialplan;

use Clearvox\Asterisk\Dialplan\Line\LineInterface;

/**
 * Main Dialplan Class. Requires a context name for this dialplan and
 * a minimum of a first extension line.
 *
 * @category Clearvox
 * @package Asterisk
 * @subpackage Dialplan
 * @author Leon Rowland <leon@rowland.nl>
 */
class Dialplan
{
    /**
     * @var string
     */
    protected $contextName;

    /**
     * @var LineInterface[]
     */
    protected $lines = array();

    /**
     * Make a new Dialplan requiring the first line in the
     * Dialplan.
     *
     * @param string $contextName
     * @param LineInterface $line
     */
    public function __construct($contextName, LineInterface $line = null)
    {
        $this->contextName = $contextName;

        if (!is_null($line)) {
            $this->lines[] = $line;
        }
    }

    /**
     * Get the Context Name for this Dialplan
     *
     * @return string
     */
    public function getName()
    {
        return $this->contextName;
    }

    /**
     * Add a Line to this dialplan.
     *
     * @param LineInterface $line
     * @return $this
     */
    public function addLine(LineInterface $line)
    {
        $this->lines[] = $line;
        return $this;
    }

    /**
     * @return LineInterface[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Helper function get the next priority number that can be used in
     * exten lines.
     *
     * @return int
     */
    public function getNextPriority()
    {
        return count($this->lines) + 1;
    }

    /**
     * Turn the complete dialplan into a string, including
     * newline characters.
     *
     * @return string
     */
    public function toString()
    {
        $string = "[{$this->contextName}]\n";
        foreach ($this->lines as $line) {
            $string .= $line->toString() . "\n";
        }

        $string .= "\n";

        return $string;
    }

    public function __toString()
    {
        return $this->toString();
    }
}