<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * Sends an arbitrary event to interested parties, with an optional <body>
 * representing additional arguments. The <body> may be specified as a ','
 * delimited list of key:value pairs.
 *
 * For AMI, each additional argument will be placed on a new line in the event
 * and the format of the event will be:
 *      Event: UserEvent
 *      UserEvent: <specified event name>
 *      [body]
 *
 * If no <body> is specified, only Event and UserEvent headers will be present.
 * For res_stasis applications, the event will be provided as a JSON blob with
 * additional arguments appearing as keys in the object and the <eventname> under
 * the 'eventname' key.
 *
 * @author Leon Rowland <leon@rowland.nl>
 */
class UserEvent implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $eventName;

    /**
     * @var array
     */
    protected $body = array();

    /**
     * Send an arbitrary user-defined event to parties interested in a channel (AMI
     * users and relevant res_stasis applications).
     *
     * @param string $eventName
     */
    public function __construct($eventName)
    {
        $this->eventName = $eventName;
    }

    /**
     * Add a new Key:Value pair to the Event body.
     *
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addBodyPart($key, $value)
    {
        $this->body[$key] = $value;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'UserEvent';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->eventName;

        if( ! empty($this->body)) {
            foreach ($this->body as $key => $value) {
                $data .= ',' . $key . ': ' . $value;
            }
        }

        return $data;
    }
}