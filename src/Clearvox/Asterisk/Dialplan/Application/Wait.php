<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Wait implements ApplicationInterface
{
    use StandardApplicationTrait;

    protected $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Wait';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->seconds;
    }
}