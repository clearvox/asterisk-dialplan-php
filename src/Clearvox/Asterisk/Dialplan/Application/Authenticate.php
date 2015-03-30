<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Authenticate implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var int
     */
    protected $maxDigits;

    /**
     * @var bool
     */
    protected $prompt;

    /*
     *
     * $maxDigits: acceptable number of digits. Stops reading after maxdigits
     * have been entered (without requiring the user to press the '#' key).
     * Defaults to 0 - no limit - wait for the user press the '#' key.
     */
    public function __construct($password, array $options = [], $maxDigits = 0, $prompt = false)
    {
        $this->password  = $password;
        $this->options   = $options;
        $this->maxDigits = $maxDigits;
        $this->prompt    = $prompt;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return int
     */
    public function getMaxDigits()
    {
        return $this->maxDigits;
    }

    /**
     * @return boolean
     */
    public function isPrompt()
    {
        return $this->prompt;
    }

    /**
     * @param array $options
     * @return Authenticate
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @param int $maxDigits
     * @return Authenticate
     */
    public function setMaxDigits($maxDigits)
    {
        $this->maxDigits = $maxDigits;
        return $this;
    }

    /**
     * @param boolean $prompt
     * @return Authenticate
     */
    public function setPrompt($prompt)
    {
        $this->prompt = $prompt;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Authenticate';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->password;

        if ( ! empty($this->options) || 0 !== $this->maxDigits || false !== $this->prompt) {
            $data .= ',';
        }

        if ( ! empty($this->options)) {
            $data .= implode('', $this->options);
        }

        if (0 !== $this->maxDigits || false !== $this->prompt) {
            $data .= ',';
        }

        if ( 0 !== $this->maxDigits) {
            $data .= $this->maxDigits;
        }

        if ( false !== $this->prompt) {
            $data .= ',' . ($this->prompt ? 1 : 0);
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
        return [
            'password' => $this->password,
            'options' => $this->options,
            'max_digits' => $this->maxDigits,
            'prompt' => $this->prompt
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