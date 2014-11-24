<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Realtime implements ApplicationInterface
{
    /**
     * @var string|null
     */
    protected $context;

    /**
     * @var string|null
     */
    protected $family;

    /**
     * @var array
     */
    protected $options;

    public function __construct($context = null, $family = null, $options = array())
    {
        $this->context = $context;
        $this->family  = $family;
        $this->options = $options;
    }

    /**
     * @return null|string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return null|string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
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