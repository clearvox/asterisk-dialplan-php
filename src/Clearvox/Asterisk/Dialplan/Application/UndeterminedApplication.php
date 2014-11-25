<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * Undetermined Application.
 *
 * @category Clearvox
 * @package Asterisk
 * @subpackage Dialplan\Application
 * @author Leon Rowland <leon@rowland.nl>
 */
class UndeterminedApplication implements ApplicationInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $data;

    public function __construct($name,$data)
    {
        $this->name = $name;
        $this->data = $data;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * The string representation of the Application.
     *
     * @return string
     */
    public function toString()
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
        return array(
            'name' => $this->name,
            'data' => $this->data
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