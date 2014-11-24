<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Go implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var int
     */
    protected $priority;

    /**
     * @var string
     */
    protected $extensions;

    /**
     * @var string
     */
    protected $context;

    /**
     * Jump to a particular priority, extension, or context.
     *
     * @param $priority
     * @param null $extensions
     * @param null $context
     */
    public function __construct($priority, $extensions = null, $context = null)
    {
        $this->priority   = $priority;
        $this->extensions = $extensions;
        $this->context    = $context;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Goto';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->priority;

        if (isset($this->extensions)) {
            $data = $this->extensions . ',' . $data;
        }

        if (isset($this->context)) {
            $data = $this->context . ',' . $data;
        }

        return $data;
    }
}