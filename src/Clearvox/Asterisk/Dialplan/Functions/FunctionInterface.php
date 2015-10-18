<?php
namespace Clearvox\Asterisk\Dialplan\Functions;

interface FunctionInterface
{
    /**
     * Returns the function in its full string representation.
     *
     * @return string
     */
    public function toString();
}