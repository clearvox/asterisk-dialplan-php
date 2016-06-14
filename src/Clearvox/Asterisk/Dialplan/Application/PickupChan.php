<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * Pickup a specified <channel> if ringing.
 *
 * @author Leon Rowland <leon@rowland.nl>
 */
class PickupChan implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var array
     */
    protected $channels = [];

    /**
     * @var array
     */
    protected $options = [];

    /**
     * PickupChan constructor.
     * @param $channel
     * @param array $otherChannels
     */
    public function __construct($channel, $otherChannels = [])
    {
        $this->channels = array_unique(
            array_merge((array)$channel, (array)$otherChannels)
        );
    }

    /**
     * Get all channels.
     *
     * @return array
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Set options on this command.
     *
     * @param string|array $options
     * @return $this
     */
    public function setOptions($options)
    {
        $this->options = (array)$options;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'PickupChan';
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

        $data .= implode('&', $this->channels);

        if (!empty($this->options)) {
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
            'channels' => $this->channels,
            'options'  => $this->options,
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