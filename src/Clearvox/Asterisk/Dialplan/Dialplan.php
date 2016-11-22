<?php
namespace Clearvox\Asterisk\Dialplan;

use Clearvox\Asterisk\Dialplan\Exception\LineNotFoundAtPriorityException;
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
    protected $lines = [];

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
     * Override the context name for this dialplan to something new
     *
     * @param $contextName
     * @return $this
     */
    public function setName($contextName)
    {
        $this->contextName = $contextName;
        return $this;
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
     * Get the line with this pattern, at this specific
     * priority
     *
     * @throws LineNotFoundAtPriorityException
     * @param string $pattern
     * @param string $priority
     * @return LineInterface
     */
    public function getLine($pattern, $priority)
    {
        foreach ($this->lines as $line) {
            if ($line->getPattern() === $pattern && $line->getPriority() == $priority) {
                return $line;
            }
        }

        throw new LineNotFoundAtPriorityException("Line not found with pattern:$pattern and priority:$priority");
    }

    /**
     * Determine if this dialplan has a matching pattern. If you want to know if
     * a pattern and a priority exist specifically then pass in the priority
     * number in.
     *
     * @param string $pattern
     * @param null|integer $priority
     * @return boolean
     */
    public function hasLine($pattern, $priority = null)
    {
        foreach ($this->lines as $line) {
            if ($line->getPattern() === $pattern) {
                if ($priority !== null) {

                    if ($line->getPriority() == $priority) {
                        return true;
                    }

                } else {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Remove a line with the matching pattern and priority.
     *
     * @param string $pattern
     * @param integer $priority
     * @throws LineNotFoundAtPriorityException
     */
    public function removeLine($pattern, $priority)
    {
        if (!$this->hasLine($pattern, $priority)) {
            throw new LineNotFoundAtPriorityException("Line not found with pattern:$pattern and priority:$priority");
        }

        $lines = $this->lines;

        foreach ($lines as $key => $line) {
            if ($line->getPattern() === $pattern && $line->getPriority() == $priority) {
                unset($this->lines[$key]);
            }
        }
    }

    /**
     * Remove all lines in this dialplan with this pattern.
     *
     * @param string $pattern
     */
    public function removeLines($pattern)
    {
        $lines = $this->lines;

        foreach ($lines as $key => $line) {
            if ($line->getPattern() === $pattern) {
                unset($this->lines[$key]);
            }
        }
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

        $lines = array_filter(
            $this->lines,
            function (LineInterface $line) use ($pattern) {
                return ($line->getPattern() === $pattern);
            }
        );

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