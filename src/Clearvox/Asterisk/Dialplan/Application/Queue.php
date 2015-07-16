<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Queue implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $announceOverride;

    /**
     * @var int
     */
    protected $timeout;

    /**
     * @var string
     */
    protected $agi;

    /**
     * @var string
     */
    protected $macro;

    /**
     * @var string
     */
    protected $goSub;

    /**
     * @var string
     */
    protected $rule;

    /**
     * @var int
     */
    protected $position;

    /**
     * In addition to transferring the call, a call may be parked and then picked
     * up by another user.
     *
     * This application will return to the dialplan if the queue does not exist,
     * or any of the join options cause the caller to not enter the queue.
     *
     * This application does not automatically answer and should be preceded
     * by an application such as Answer(), Progress(), or Ringing().
     *
     * This application sets the following channel variable upon completion:
     *      ${QUEUESTATUS}: The status of the call as a text string.
     *          TIMEOUT
     *          FULL
     *          JOINEMPTY
     *          LEAVEEMPTY
     *          JOINUNAVAIL
     *          LEAVEUNAVAIL
     *          CONTINUE
     *
     * @param string $name
     * @param array $options
     */
    public function __construct($name, array $options = array())
    {
        $this->name = $name;
        $this->options = $options;
    }

    public function getQueueName()
    {
        return $this->name;
    }

    /**
     * options
     * C: Mark all calls as "answered elsewhere" when cancelled.
     *
     * c: Continue in the dialplan if the callee hangs up.
     *
     * d: data-quality (modem) call (minimum delay).
     *
     * F([[context^]exten^]priority): When the caller hangs up, transfer
     * the *called member* to the specified destination and *start* execution at that location.
     *      NOTE: Any channel variables you want the called channel to inherit
     *            from the caller channel must be prefixed with one or two underbars ('_').
     *
     * F: When the caller hangs up, transfer the *called member* to the
     * next priority of the current extension and *start* execution at that location.
     *      NOTE: Any channel variables you want the called channel to inherit
     *            from the caller channel must be prefixed with one or two underbars ('_').
     *      NOTE: Using this option from a Macro() or GoSub() might not make sense as
     *            there would be no return points.
     *
     * h: Allow *callee* to hang up by pressing '*'.
     *
     * H: Allow *caller* to hang up by pressing '*'.
     *
     * n: No retries on the timeout; will exit this application and go to the next step.
     *
     * i: Ignore call forward requests from queue members and do nothing when they are requested.
     *
     * I: Asterisk will ignore any connected line update requests or any redirecting party
     *    update requests it may receive on this dial attempt.
     *
     * r: Ring instead of playing MOH. Periodic Announcements are still made, if applicable.
     *
     * R: Ring instead of playing MOH when a member channel is actually ringing.
     *
     * t: Allow the *called* user to transfer the calling user.
     *
     * T: Allow the *calling* user to transfer the call.
     *
     * w: Allow the *called* user to write the conversation to disk via Monitor.
     *
     * W: Allow the *calling* user to write the conversation to disk via Monitor.
     *
     * k: Allow the *called* party to enable parking of the call by sending the DTMF
     *    sequence defined for call parking in "features.conf".
     *
     * K: Allow the *calling* party to enable parking of the call by sending the DTMF
     *    sequence defined for call parking in "features.conf".
     *
     * x: Allow the *called* user to write the conversation to disk via MixMonitor.
     *
     * X: Allow the *calling* user to write the conversation to disk via MixMonitor.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Return all options set for this queue.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * The URL will be sent to the called party if the channel supports it
     *
     * @param string $url
     * @return $this
     */
    public function setURL($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Returns the set URL for this Queue.
     *
     * @return string
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     *
     * @return string
     */
    public function getAnnounceOverride()
    {
        return $this->announceOverride;
    }

    /**
     * NO DOCUMENT IN ASTERISK.
     *
     * @param string $announceOverride
     * @return Queue
     */
    public function setAnnounceOverride($announceOverride)
    {
        $this->announceOverride = $announceOverride;
        return $this;
    }

    /**
     * Will cause the queue to fail out after a specified number of seconds,
     * checked between each "queues.conf" <timeout> and <retry> cycle.
     *
     * @param int $seconds
     * @return $this
     */
    public function setTimeout($seconds)
    {
        $this->timeout = $seconds;
        return $this;
    }

    /**
     * Return the set timeout for this queue
     *
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Get the queues set AGI script to calling party's! channel
     * `
     * @return string
     */
    public function getAGI()
    {
        return $this->agi;
    }

    /**
     * Will setup an AGI script to be executed on the calling party's channel once they are connected to a queue member.
     *
     * @param string $agi
     * @return Queue
     */
    public function setAGI($agi)
    {
        $this->agi = $agi;
        return $this;
    }

    /**
     * Get the queues set macro for the called party.
     *
     * @return string
     */
    public function getMacro()
    {
        return $this->macro;
    }

    /**
     * Will run a macro on the called party's channel (the queue member) once the parties are connected.
     *
     * @param string $macro
     * @return Queue
     */
    public function setMacro($macro)
    {
        $this->macro = $macro;
        return $this;
    }

    /**
     * Get the queues set go sub for the called party.
     *
     * @return string
     */
    public function getGoSub()
    {
        return $this->goSub;
    }

    /**
     * Will run a gosub on the called party's channel (the queue member) once the parties are connected.
     *
     * @param string $goSub
     * @return Queue
     */
    public function setGoSub($goSub)
    {
        $this->goSub = $goSub;
        return $this;
    }

    /**
     * Get the rule override set for this queue.
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Will cause the queue's defaultrule to be overridden by the rule specified.
     *
     * @param string $rule
     * @return Queue
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
        return $this;
    }

    /**
     * Get the set position for this Queue.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Attempt to enter the caller into the queue at the numerical position specified.
     * '1' would attempt to enter the caller at the head of the queue, and '3'
     * would attempt to place the caller third in the queue.
     *
     * @param int $position
     * @return Queue
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Queue';
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

        if(!empty($this->position)) {
            $line[0] = $this->position;
            $line[1] = null;
            $line[2] = null;
            $line[3] = null;
            $line[4] = null;
            $line[5] = null;
            $line[6] = null;
            $line[7] = null;
            $line[8] = null;
        }

        if(!empty($this->rule)) {
            $line[1] = $this->rule;
            $line[2] = null;
            $line[3] = null;
            $line[4] = null;
            $line[5] = null;
            $line[6] = null;
            $line[7] = null;
            $line[8] = null;
        }

        if (!empty($this->goSub)) {
            $line[2] = $this->goSub;
            $line[3] = null;
            $line[4] = null;
            $line[5] = null;
            $line[6] = null;
            $line[7] = null;
            $line[8] = null;
        }

        if (!empty($this->macro)) {
            $line[3] = $this->macro;
            $line[4] = null;
            $line[5] = null;
            $line[6] = null;
            $line[7] = null;
            $line[8] = null;
        }

        if (!empty($this->agi)) {
            $line[4] = $this->agi;
            $line[5] = null;
            $line[6] = null;
            $line[7] = null;
            $line[8] = null;
        }

        if (!empty($this->timeout)) {
            $line[5] = $this->timeout;
            $line[6] = null;
            $line[7] = null;
            $line[8] = null;
        }

        if (!empty($this->announceOverride)) {
            $line[6] = $this->announceOverride;
            $line[7] = null;
            $line[8] = null;
        }

        if (!empty($this->url)) {
            $line[7] = $this->url;
            $line[8] = null;
        }

        if (!empty($this->options)) {
            $line[8] = implode('', $this->options);
        }

        $line[9] = $this->name;

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
            'name'              => $this->name,
            'options'           => $this->options,
            'url'               => $this->url,
            'announce_override' => $this->announceOverride,
            'timeout'           => $this->timeout,
            'agi'               => $this->agi,
            'macro'             => $this->macro,
            'go_sub'            => $this->goSub,
            'rule'              => $this->rule,
            'position'          => $this->position
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