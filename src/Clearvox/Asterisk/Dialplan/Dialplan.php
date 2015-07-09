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
     * @var bool
     */
    protected $extended = false;

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
     * @param string $pattern
     * @return int
     */
    public function getNextPriority($pattern = null)
    {
        if (null === $pattern) {
            return count($this->lines) + 1;
        }

        $lines = array_filter($this->lines, function(LineInterface $line) use ($pattern){
            return ($line->getPattern() === $pattern);
        });

        return count($lines) + 1;
    }

    /**
     * Set that this dialplan should extend another dialplan with the same name
     *
     * @see https://wiki.asterisk.org/wiki/display/AST/Adding+to+an+existing+section
     * @param bool $extend
     * @return $this
     */
    public function setExtended($extend)
    {
        $this->extended = $extend;
        return $this;
    }

    /**
     * Is this dialplan an extended dialplan?
     *
     * @see https://wiki.asterisk.org/wiki/display/AST/Adding+to+an+existing+section
     * @return bool
     */
    public function isExtended()
    {
        return $this->extended;
    }

    /**
     * Turn the complete dialplan into a string, including
     * newline characters.
     *
     * @return string
     */
    public function toString()
    {
        if ($this->extended) {
            $string = "[{$this->contextName}](+)\n";
        } else {
            $string = "[{$this->contextName}]\n";
        }

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