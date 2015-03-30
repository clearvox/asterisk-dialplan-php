<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * Answer a channel if ringing.
 *
 * @category Clearvox
 * @package Asterisk
 * @subpackage Dialplan\Application
 * @author Leon Rowland <leon@rowland.nl>
 */
class Answer implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var int
     */
    protected $delay;

    /**
     * Asterisk will wait this number of milliseconds before returning to
     * the dialplan after answering the call.
     *
     * @param int $delay
     */
    public function __construct($delay = null)
    {
        $this->delay = $delay;
    }

    /**
     * The number of milliseconds to way before returning to the dialplan
     *
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Answer';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->delay;
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'delay' => $this->delay
        );
    }

    /**
     * Turns this Application into a json representation
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }
}