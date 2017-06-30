<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Stasis implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $application;

    /**
     * @var array
     */
    protected $arguments = array();

    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Return the given applicatoin for this Stasis application
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->application;
    }

    /**
     * Add an argument to this Stasis application.
     *
     * @param string $argument
     * @return $this
     */
    public function addArgument($argument)
    {
        $this->arguments[] = $argument;
        return $this;
    }

    /**
     * Get all arguments for this Stasis application.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Stasis';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->application;

        if ( ! empty($this->arguments)) {
            $data .= ',';
            $data .= implode(',', $this->arguments);
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
        return array(
            'application' => $this->application,
            'arguments' => $this->arguments
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