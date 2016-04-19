<?php
namespace Clearvox\Asterisk\Dialplan\Reader;

use Clearvox\Asterisk\Dialplan\Dialplan;
use Closure;

class Reader
{
    /**
     * @var Closure
     */
    protected $onStartContextClosure;

    public function __construct()
    {
        // Register the default closures
        $this->onStartContextClosure = function($line) {
            return $this->startContext($line);
        };
    }

    public function read($contents)
    {
        $lines = explode(PHP_EOL, $contents);

        foreach ($lines as $line) {
            // Starting
            if(strpos($line, '[') === 0) {
                $dialplan = $this->onStartContextClosure($line);
            }


        }
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

    /**
     * Build a simple dialplan class from the line
     *
     * @param string $line
     * @return Dialplan
     */
    protected function startContext($line)
    {
        $contextName = str_replace(['[', ']'], '', $line);
        return new Dialplan($contextName);
    }
}