<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Set implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $preparedName;

    /**
     * @var string
     */
    protected $value;

    /**
     * Set the value of a channel variable or dialplan function.
     *
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name  = $this->preparedName = $name;
        $this->value = $value;
    }

    /**
     * Will make the variable inherit into channels created from the current channel.
     *
     * @return $this
     */
    public function inherit()
    {
        $this->preparedName = '_' . $this->name;
        return $this;
    }

    /**
     * Will make the variable inherit into channels created from the current channel
     * and all children channels.
     *
     * @return $this
     */
    public function inheritChildren()
    {
        $this->preparedName = '__' . $this->name;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Set';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->preparedName . '=' . $this->value;
    }
}