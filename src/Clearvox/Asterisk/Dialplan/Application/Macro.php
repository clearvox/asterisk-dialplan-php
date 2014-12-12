<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Macro implements ApplicationInterface
{
    use StandardApplicationTrait;

    protected $macroName;

    protected $arguments = array();

    public function __construct($macroName)
    {
        $this->macroName = $macroName;
    }

    public function getMacroName()
    {
        return $this->macroName;
    }

    public function addArgument($argument)
    {
        $this->arguments[] = $argument;
        return $this;
    }

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
        return 'Macro';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->macroName;

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
            'name' => $this->macroName,
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