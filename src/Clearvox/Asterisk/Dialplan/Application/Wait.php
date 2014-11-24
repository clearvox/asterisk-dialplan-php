<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Wait implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var int
     */
    protected $seconds;

    public function __construct($seconds)
    {
        $this->seconds = $seconds;
    }

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
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