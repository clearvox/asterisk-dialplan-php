<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class NoOp implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $text;

    /**
     * This application does nothing. However, it is useful for debugging purposes.
     *
     * This method can be used to see the evaluations of variables or functions without
     * having any effect.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'NoOp';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->text;
    }
}