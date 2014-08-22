<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Realtime implements ApplicationInterface
{
    protected $context;

    protected $family;

    protected $options;

    public function __construct($context = null, $family = null, $options = array())
    {
        $this->context = $context;
        $this->family  = $family;
        $this->options = $options;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Realtime';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->context . '@' . $this->family;

        if (!empty($this->options)) {
            $data .= '/' . implode('', $this->options);
        }

        return $data;
    }

    /**
     * The string representation of the Application.
     *
     * @return string
     */
    public function toString()
    {
        return $this->getName() . '/' . $this->getData();
    }
}