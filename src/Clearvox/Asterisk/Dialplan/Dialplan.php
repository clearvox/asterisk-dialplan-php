<?php

namespace Clearvox\Asterisk\Dialplan;

use Clearvox\Asterisk\Dialplan\Exception\LineNotFoundAtPriorityException;
use Clearvox\Asterisk\Dialplan\Line\LineInterface;

/**
 * Main Dialplan Class. Requires a context name for this dialplan and
 * a minimum of a first extension line.
 *
 * @category   Clearvox
 * @package    Asterisk
 * @subpackage Dialplan
 * @author     Leon Rowland <leon@rowland.nl>
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
     */
    public function __construct(string $contextName, LineInterface $line = null)
    {
        $this->contextName = $contextName;

        if (!is_null($line)) {
            $this->lines[] = $line;
        }
    }

    /**
     * Get the Context Name for this Dialplan
     */
    public function getName(): string
    {
        return $this->contextName;
    }

    /**
     * Override the context name for this dialplan to something new
     */
    public function setName(string $contextName): Dialplan
    {
        $this->contextName = $contextName;

        return $this;
    }

    /**
     * Add a Line to this dialplan.
     */
    public function addLine(LineInterface $line): Dialplan
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * @return LineInterface[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * Get the line with this pattern, at this specific
     * priority
     *
     *@throws LineNotFoundAtPriorityException
     */
    public function getLine(string $pattern, string $priority): LineInterface
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
     */
    public function hasLine(string $pattern, string $priority = null): bool
    {
        foreach ($this->lines as $line) {
            if ($line->getPattern() === $pattern) {
                if ($priority !== null) {

                    if ($line->getPriority() === $priority) {
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
     * @throws LineNotFoundAtPriorityException
     */
    public function removeLine(string $pattern, int $priority)
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
     */
    public function removeLines(string $pattern)
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
     */
    public function getNextPriority(string $pattern = null): int
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
     * Is this dialplan an extended dialplan?
     *
     * @see https://wiki.asterisk.org/wiki/display/AST/Adding+to+an+existing+section
     */
    public function isExtended(): bool
    {
        return $this->extended;
    }

    /**
     * Set that this dialplan should extend another dialplan with the same name
     *
     * @see https://wiki.asterisk.org/wiki/display/AST/Adding+to+an+existing+section
     */
    public function setExtended(bool $extend): Dialplan
    {
        $this->extended = $extend;

        return $this;
    }

    /**
     * Turn the complete dialplan into a string, including
     * newline characters.
     */
    public function toString(): string
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

    public function addLineToTop(LineInterface $receivedLine, string $pattern): Dialplan
    {
        $nonEmptyLines = [];
        $emptyLines    = [];

        foreach ($this->lines as $line) {
            if (empty($line->toString())) {
                $emptyLines[] = $line;
            } else {
                $nonEmptyLines[] = $line;
            }
        }

        // Increase priority for matching lines
        foreach ($nonEmptyLines as $line) {
            if ($line->getPattern() === $pattern && is_numeric($line->getPriority())) {
                $line->setPriority((int) $line->getPriority() + 1);
            }
        }

        $this->lines = array_merge($emptyLines, [$receivedLine], $nonEmptyLines);

        return $this;
    }
}