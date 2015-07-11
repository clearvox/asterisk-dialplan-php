<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Gosub implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $priority;

    /**
     * @var string
     */
    protected $context;

    /**
     * @var string
     */
    protected $exten;

    /**
     * @var array
     */
    protected $arguments = array();

    public function __construct(
        $priority,
        $context = null,
        $exten = null,
        $arguments = array()
    ) {
        $this->priority  = $priority;
        $this->context   = $context;
        $this->exten     = $exten;
        $this->arguments = $arguments;
    }

    /**
     * Return the priority set to go to.
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Return the context set to go to.
     *
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Return the extension/pattern set to go to.
     *
     * @return string
     */
    public function getExten()
    {
        return $this->exten;
    }

    /**
     * Return all arguments attached to this GoSub.
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Gosub';
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

        // Always add the priority
        $data .= $this->priority;

        if (isset($this->context)) {
            if(isset($this->exten)) {
                $data = $this->context . ',' . $this->exten . ',' . $data;
            } else {
                $data = $this->context . ',' . $data;
            }
        }

        if (!empty($this->arguments)) {
            $data .= '(' . implode(',', $this->arguments) . ')';
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
            'priority' => $this->priority,
            'context' => $this->context,
            'exten' => $this->exten,
            'arguments' => $this->arguments
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