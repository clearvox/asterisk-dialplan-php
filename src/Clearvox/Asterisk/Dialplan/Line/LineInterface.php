<?php
namespace Clearvox\Asterisk\Dialplan\Line;

interface LineInterface
{
    public function getPattern();

    public function getPriority();

    /**
     * @return \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    public function getApplication();

    public function toString();
}