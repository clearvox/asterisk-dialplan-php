<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Dial implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var array
     */
    protected $initialTarget = array();

    /**
     * @var array
     */
    protected $targets = array();

    /**
     * @var int|null
     */
    protected $timeout;

    /**
     * @var string|null
     */
    protected $url;

    /**
     * @var array
     */
    protected $dialOptions = array();

    public function __construct($technology, $resource, $timeout = null, $url = null)
    {
        $this->initialTarget[0] = $technology;
        $this->initialTarget[1] = $resource;

        $this->timeout = $timeout;
        $this->url     = $url;

        if (is_null($timeout) && ! is_null($url)) {
            throw new \InvalidArgumentException("Requires a Timeout to add a URL");
        }
    }

    /**
     * Add a new target to the Dials.
     *
     * @param string $technology
     * @param string $resource
     * @return $this
     */
    public function addTarget($technology, $resource)
    {
        $this->targets[] = array($technology, $resource);
        return $this;
    }

    /**
     * Specify an option flag for this Dial. Requires the timeout
     * to be set.
     *
     * @param string $dialOption
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addOption($dialOption)
    {
        if (is_null($this->timeout)) {
            throw new \InvalidArgumentException("Requires a Timeout to add Options");
        }

        $this->dialOptions[] = $dialOption;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Dial';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->initialTarget[0] . '/' . $this->initialTarget[1];

        if (!empty($this->targets)) {
            foreach ($this->targets as $target) {
                $data .= '&' . $target[0] . '/' . $target[1];
            }
        }

        if (isset($this->timeout)) {
            $data .= ',' . $this->timeout;
        }

        if (!empty($this->dialOptions)) {
            $data .= ',';

            foreach ($this->dialOptions as $dialOption) {
                $data .= $dialOption;
            }
        } elseif (isset($this->url)) {
            $data .= ',';
        }

        if (isset($this->url)) {
            $data .= ',' . $this->url;
        }

        return $data;
    }
}