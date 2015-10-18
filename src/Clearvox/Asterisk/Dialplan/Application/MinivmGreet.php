<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class MinivmGreet implements ApplicationInterface
{
    use StandardApplicationTrait;

    protected $account;

    protected $options = array();

    public function __construct($account, array $options = array())
    {
        $this->account = $account;
        $this->options = $options;
    }

    public function getAccount()
    {
        return $this->account;
    }

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
        return 'MinivmGreet';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $line = $this->account;

        if(!empty($this->options)) {
            $line .= ',' . implode('', $this->options);
        }

        return $line;
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'account' => $this->account,
            'options' => $this->options,
        ];
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