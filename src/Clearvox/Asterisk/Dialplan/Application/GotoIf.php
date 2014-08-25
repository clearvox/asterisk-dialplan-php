<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class GotoIf implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $condition;

    /**
     * @var Go
     */
    protected $true;

    /**
     * @var Go
     */
    protected $false;

    public function __construct($condition, Go $true = null, Go $false = null)
    {
        $this->condition = $condition;
        $this->true      = $true;
        $this->false     = $false;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'GotoIf';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = '';

        $data .= $this->condition . '?';

        if (isset($this->true)) {
            $data .= $this->true->getData();
        }

        if (isset($this->false)) {
            $data .= ':' . $this->false->getData();
        }

        return $data;
    }
}