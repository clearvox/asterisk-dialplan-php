<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Hangup implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string|null
     */
    protected $causecode;

    public function __construct($causecode = null)
    {
        $this->causecode = $causecode;
    }

    /**
     * @return null|string
     */
    public function getCausecode()
    {
        return $this->causecode;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Hangup';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->causecode;
    }
}