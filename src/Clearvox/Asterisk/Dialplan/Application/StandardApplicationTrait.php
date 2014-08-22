<?php
namespace Clearvox\Asterisk\Dialplan\Application;

trait StandardApplicationTrait
{
    public function toString()
    {
        return $this->getName() . '(' . $this->getData() . ')';
    }
}