<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class RemoveQueueMember implements ApplicationInterface
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
     * If the interface is *NOT* in the queue it will return an error.
     * This application sets the following channel variable upon completion:
     *      ${RQMSTATUS}:
     *          REMOVED
     *          NOTINQUEUE
     *          NOSUCHQUEUE
     *          NOTDYNAMIC
     *
     * @param $queueName
     */
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
     * @return string
     */
    public function getInterface()
    {
        return $this->interface;
    }

    /**
     * Set the interface to remove from the queue, if not set, will remove
     * the current interface.
     *
     * @param string $interface
     * @return RemoveQueueMember
     */
    public function setInterface($interface)
    {
        $this->interface = $interface;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'RemoveQueueMember';
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

        if (isset($this->interface)) {
            $line[0] = $this->interface;
        }

        $line[1] = $this->queueName;

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
            'name' => $this->queueName,
            'interface' => $this->interface,
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