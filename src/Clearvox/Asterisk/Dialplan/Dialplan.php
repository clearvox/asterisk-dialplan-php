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

    public function __construct($contextName, LineInterface $line)
    {
        $this->contextName = $contextName;
        $this->lines[] = $line;
    }

    /**
     * Get the Context Name for this Dialplan
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

    public function toString()
    {
        $string = "[{$this->contextName}]\n";
        foreach ($this->lines as $line) {
            $string .= $line->toString() . "\n";
        }

        $string .= "\n";

        return $string;
    }
}