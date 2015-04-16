<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Read implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $variable;

    /**
     * @var array
     */
    protected $filenames = array();

    /**
     * @var int
     */
    protected $maxDigits;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var int
     */
    protected $attempts;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * Reads a #-terminated string of digits a certain number of times from the user
     * in to the given <variable>.
     * This application sets the following channel variable upon completion:
     * ${READSTATUS}: This is the status of the read operation.
     *
     * variable
     * The input digits will be stored in the given <variable> name.
     *
     * filename
     * file(s) to play before reading digits or tone with option i
     *
     * maxdigits
     * Maximum acceptable number of digits. Stops reading after <maxdigits> have been entered
     * (without requiring the user to press the '#' key). Defaults to '0' - no limit - wait for the user
     * press the '#' key. Any value below '0' means the same. Max accepted value is '255'.
     *
     * options
     *  - s: to return immediately if the line is not up.
     *  - i: to play  filename as an indication tone from your "indication s.conf".
     *  - n: to read digits even if the line is not up.
     *
     * attempts
     * If greater than '1', that many <attempts> will be made in the event no data is entered.
     *
     * timeout
     * The number of seconds to wait for a digit response. If greater than '0', that value will override
     * the default timeout. Can be floating point.
     *
     * @param $variable
     * @param $maxDigits
     * @param array $options
     * @param $attempts
     * @param $timeout
     */
    public function __construct(
        $variable,
        $maxDigits = null,
        array $options = array(),
        $attempts = null,
        $timeout = null
    ) {
        $this->variable  = $variable;
        $this->maxDigits = $maxDigits;
        $this->options   = $options;
        $this->attempts  = $attempts;
        $this->timeout   = $timeout;
    }

    /**
     * Return the set variable name for Read.
     *
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * Add a filename to this instance of Read.
     *
     * @param string $filename
     * @return $this
     */
    public function addFilename($filename)
    {
        $this->filenames[] = $filename;
        return $this;
    }

    /**
     * Return the set filenames to play before the listening of the DTMF codes.
     *
     * @return array
     */
    public function getFilenames()
    {
        return $this->filenames;
    }

    /**
     * Return the set max digits for the this Read
     *
     * @return int
     */
    public function getMaxDigits()
    {
        return $this->maxDigits;
    }

    /**
     * Add an option to this instance of Read.
     *
     * @param string $option
     * @return $this
     */
    public function addOption($option)
    {
        $this->options[] = $option;
        return $this;
    }

    /**
     * Return the set options for this Read
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Return the set attempts for this Read.
     *
     * @return int
     */
    public function getAttempts()
    {
        return $this->attempts;
    }

    /**
     * Set the timeout for this Read application.
     *
     * @param int $timeout
     * @return $this
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Return the set timeout for this Read.
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Read';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $line = array();

        if (!empty($this->timeout)) {
            $line[0] = $this->timeout;
            $line[1] = null;
            $line[2] = null;
            $line[3] = null;
            $line[4] = null;
        }

        if (!empty($this->attempts)) {
            $line[1] = $this->attempts;
            $line[2] = null;
            $line[3] = null;
            $line[4] = null;
        }

        if (!empty($this->options)) {
            $line[2] = implode('', $this->options);
            $line[3] = null;
            $line[4] = null;
        }

        if (!empty($this->maxDigits)) {
            $line[3] = $this->maxDigits;
            $line[4] = null;
        }

        if (!empty($this->filenames)) {
            $line[4] = implode('&', $this->filenames);
        }

        $line[5] = $this->variable;

        return implode(',', array_reverse($line));
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'variable'   => $this->variable,
            'filenames'  => $this->filenames,
            'max_digits' => $this->maxDigits,
            'options'    => $this->options,
            'attempts'   => $this->attempts,
            'timeout'    => $this->timeout
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