<?php
namespace Clearvox\Asterisk\Dialplan\Application;

interface ApplicationInterface
{
    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName();

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData();

    /**
     * The string representation of the Application.
     *
     * @return string
     */
    public function toString();

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray();

    /**
     * Turns this Application into a json representation
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0);
}