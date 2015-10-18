<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class EndWhileApplication implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'EndWhile';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return '';
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [];
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