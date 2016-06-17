<?php
namespace Clearvox\Asterisk\Dialplan\Reader;

use Clearvox\Asterisk\Dialplan\Dialplan;
use Clearvox\Asterisk\Dialplan\Reader\Line\LineReaderInterface;
use Closure;

class Reader
{
    /**
     * @var Closure
     */
    protected $onStartContextClosure;

    /**
     * @var LineReaderInterface[]
     */
    protected $lines = [];

    /**
     * Reader constructor.
     * @param LineReaderInterface[] $lines
     */
    public function __construct($lines)
    {
        $this->lines = $lines;

        // Register the default closures
        $this->onStartContextClosure = function($line) {
            $contextName = str_replace(['[', ']'], '', $line);
            return new Dialplan($contextName);
        };
    }

    /**
     * Read the contents of the string, and return an instance of
     * @param string $contents
     * @return Dialplan
     */
    public function read($contents)
    {
        $onStartContext = $this->onStartContextClosure;

        $lines = explode(PHP_EOL, $contents);

        $dialplan = null;

        foreach ($lines as $line) {
            // Starting
            if(strpos($line, '[') === 0) {
                $dialplan = $onStartContext($line);
            }

            // Match the lines
            foreach($this->lines as $lineReader) {
                $matches = [];

                if(preg_match($lineReader->getMatchFormat(), $line, $matches)) {
                    $dialplan->addLine($lineReader->getInstance($matches));
                }
            }
        }

        if(is_null($dialplan)) {
            // throw exception
        }

        return $dialplan;
    }

    /**
     * Override what should happen when a context is found from
     * the read function.  It should return an instance of the
     * Dialplan class to work correctly.
     *
     * @param Closure $closure
     * @return $this
     */
    public function onStartContext(Closure $closure)
    {
        $this->onStartContextClosure = $closure;
        return $this;
    }
}