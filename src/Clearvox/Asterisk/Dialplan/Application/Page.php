<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Page implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var array
     */
    protected $targets = [];

    /**
     * @var int|null
     */
    protected $timeout;

    /**
     * @var array
     */
    protected $options = [];

    public function __construct($technology, $resource, $timeout = null)
    {
        $this->addTarget($technology, $resource);

        $this->timeout = $timeout;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Page';
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
        $this->targets[] = [$technology, $resource];
        return $this;
    }

    /**
     * Get all targets for this Dial.
     *
     * @return array
     */
    public function getTargets()
    {
        return $this->targets;
    }

    /**
     * Specify an option flag for this Dial. Requires the timeout
     * to be set.
     *
     * @param string $option
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function addOption($option)
    {
        $this->options[] = $option;
        return $this;
    }

    /**
     * Get all dial options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
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

        if (!empty($this->targets)) {
            foreach ($this->targets as $target) {
                $data .= '&' . $target[0] . '/' . $target[1];
            }
        }

        if (empty($this->options) && !empty($this->timeout)) {
            $data .= ',';
        }elseif (!empty($this->options)) {
            $data .= ',';
            foreach ($this->options as $dialOption) {
                $data .= $dialOption;
            }
        }

        if (isset($this->timeout)) {
            $data .= ',' . $this->timeout;
        }

        return substr($data, 1);
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'targets' => $this->getTargets(),
            'options' => $this->options,
            'timeout' => $this->timeout,
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