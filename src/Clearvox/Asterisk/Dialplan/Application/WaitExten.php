<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 *
 * This application waits for the user to enter a new extension for a specified
 * number of <seconds>.
 * WARNING!!!: Use of the application 'WaitExten' within a macro will not
 * function as expected. Please use the 'Read' application in
 * order to read DTMF from a channel currently executing a macro.
 *
 * Class WaitExten
 * @package Clearvox\Asterisk\Dialplan\Application
 */
class WaitExten implements ApplicationInterface
{

    use StandardApplicationTrait;

    /**
     * @var int
     */
    protected $seconds;

    /**
     * @var array
     */
    protected $options;

    /**
     * @return int
     */
    public function getSeconds()
    {
        return $this->seconds;
    }

    /**
     * @param int $seconds
     * @return $this
     */
    public function setSeconds($seconds)
    {
        $this->seconds = $seconds;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * m([x]): Provide music on hold to the caller while waiting for an
     * extension.
     * x - Specify the class for music on hold.
     * *CHANNEL(musicclass) will be used instead if set*
     *
     * @param array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'WaitExten';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = '';

        if ( ! empty($this->seconds)) {
            $data .= $this->seconds;
        }

        if( ! empty($this->options)) {
            $data .= ',' . implode('', $this->options);
        }

        return $data;
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'seconds' => $this->seconds,
            'options' => $this->getOptions()
        ];
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