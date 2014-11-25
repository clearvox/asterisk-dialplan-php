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

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'causecode' => $this->causecode
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