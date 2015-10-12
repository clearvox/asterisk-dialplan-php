<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class Voicemail implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var array
     */
    protected $mailboxes = [];

    /**
     * @var array
     */
    protected $options = [];

    public function __construct($mailbox, $context = null, array $options = array())
    {
        $this
            ->addMailbox($mailbox, $context)
            ->setOptions($options);
    }

    /**
     * Adds another mailbox to this voicemail.
     *
     * @param string $mailbox
     * @param string|null $context
     * @return $this
     */
    public function addMailbox($mailbox, $context = null)
    {
        $this->mailboxes[] = ['mailbox' => $mailbox, 'context' => $context];
        return $this;
    }

    /**
     * Return all mailboxes for this voicemail application.
     *
     * @return array
     */
    public function getMailboxes()
    {
        return $this->mailboxes;
    }

    /**
     * b: Play the 'busy' greeting to the calling party.
     *
     * d([c]): Accept digits for a new extension in context <c>, if played
     * during the greeting. Context defaults to the current context.
     *
     * g(#): Use the specified amount of gain when recording the voicemail
     * message. The units are whole-number decibels (dB). Only works on supported
     * technologies, which is DAHDI only.
     *
     * s: Skip the playback of instructions for leaving a message to the calling party.
     *
     * u: Play the 'unavailable' greeting.
     *
     * U: Mark message as 'URGENT'.
     *
     * P: Mark message as 'PRIORITY'.
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
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Voicemail';
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

        $mailboxes = [];
        foreach ($this->mailboxes as $mailbox) {
            if(is_null($mailbox['context'])) {
                $mailboxes[] = $mailbox['mailbox'];
            } else {
                $mailboxes[] = $mailbox['mailbox'] . '@' . $mailbox['context'];
            }
        }

        $data .= implode('&', $mailboxes);

        if(!empty($this->options)) {
            $data .= ',' . implode('', $this->options);
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
            'mailboxes' => $this->mailboxes,
            'options'   => $this->options,
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