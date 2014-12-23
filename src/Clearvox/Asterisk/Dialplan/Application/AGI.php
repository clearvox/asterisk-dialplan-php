<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class AGI implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var array
     */
    protected $arguments = array();

    public function __construct($command)
    {
        $this->command = $command;
    }

    /**
     * Return the given command for this AGI application
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Add an argument to this AGI application.
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
     * Get all arguments for this AGI application.
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
        return 'AGI';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->command;

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
            'command' => $this->command,
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