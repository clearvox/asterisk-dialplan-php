<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class AddQueueMember implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $queueName;

    /**
     * @var string
     */
    protected $interface;

    /**
     * @var int
     */
    protected $penalty;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var string
     */
    protected $memberName;

    /**
     * @var string
     */
    protected $stateInterface;

    public function __construct($queueName)
    {
        $this->queueName = $queueName;
    }

    /**
     * @return string
     */
    public function getQueueName()
    {
        return $this->queueName;
    }

    /**
     * The name of the queue to add a member to
     *
     * @param string $queueName
     * @return AddQueueMember
     */
    public function setQueueName($queueName)
    {
        $this->queueName = $queueName;
        return $this;
    }

    /**
     * @return string
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * The interface to add to the queue, if not specified, uses the current interface
     *
     * @param string $interface
     * @return AddQueueMember
     */
    public function setInterface($interface)
    {
        $this->interface = $interface;
        return $this;
    }

    /**
     * @return int
     */
    public function getPenalty()
    {
        return $this->penalty;
    }

    /**
     * Integer greater than or equal to 0, available members with lower penalties will get calls first
     *
     * @param int $penalty
     * @return AddQueueMember
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * In 1.6 there are no options.
     *
     * @param array $options
     * @return AddQueueMember
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberName()
    {
        return $this->memberName;
    }

    /**
     * A specific member name to be added. This is simply a text label to allow easy identification of a
     * queue member from either the queue_log file or AMI events.
     *
     * @param string $memberName
     * @return AddQueueMember
     */
    public function setMemberName($memberName)
    {
        $this->memberName = $memberName;
        return $this;
    }

    /**
     * @return string
     */
    public function getStateInterface()
    {
        return $this->stateInterface;
    }

    /**
     * An alternate interface to be used to determine the state of the member
     *
     * @param string $stateInterface
     * @return AddQueueMember
     */
    public function setStateInterface($stateInterface)
    {
        $this->stateInterface = $stateInterface;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'AddQueueMember';
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

        if(!empty($this->stateInterface)) {
            $line[0] = $this->stateInterface;
            $line[1] = null;
            $line[2] = null;
            $line[3] = null;
            $line[4] = null;
        }

        if (!empty($this->memberName)) {
            $line[1] = $this->memberName;
            $line[2] = null;
            $line[3] = null;
            $line[4] = null;
        }

        if (!empty($this->options)) {
            $line[2] = implode('', $this->options);
            $line[3] = null;
            $line[4] = null;
        }

        if (!empty($this->penalty)) {
            $line[3] = $this->penalty;
            $line[4] = null;
        }

        if (!empty($this->interface)) {
            $line[4] = $this->interface;
        }

        $line[5] = $this->queueName;

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
            'name'            => $this->queueName,
            'interface'       => $this->interface,
            'penalty'         => $this->penalty,
            'options'         => $this->options,
            'member_name'     => $this->memberName,
            'state_interface' => $this->stateInterface,
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