<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * This application can pickup a specified ringing channel.  The channel to pickup
 * can be specified in the following ways.
 *
 * 1) If no <extension> targets are specified, the application will pickup a
 * channel matching the pickup group of the requesting channel.
 *
 * 2) If the <extension> is specified with a <context> of the special string
 * 'PICKUPMARK' (for example 10@PICKUPMARK), the application will pickup a channel
 * which has defined the channel variable ${PICKUPMARK} with the same value as
 * <extension> (in this example, '10').
 *
 * 3) If the <extension> is specified with or without a <context>, the channel
 * with a matching <extension> and <context> will be picked up.  If no <context>
 * is specified, the current context will be used.
 *
 * NOTE: The <extension> is typically set on matching channels by the dial
 * application that created the channel.  The <context> is set on matching
 * channels by the channel driver for the device.
 *
 * @author Leon Rowland <leon@rowland.nl>
 */
class Pickup implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var array
     */
    protected $extensions = [];

    public function __construct($extension = [])
    {
        $this->extensions = (array)$extension;
    }

    /**
     * Add another extension to this pick in the format of
     *
     * extension[@context]
     *
     * @param string $extension
     * @return $this
     */
    public function addExtension($extension)
    {
        $this->extensions = array_merge($this->extensions, (array)$extension);
        return $this;
    }

    /**
     * Get all extensions set for this application.
     *
     * @return array
     */
    public function getExtensions()
    {
        return $this->extensions;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Pickup';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return implode('&', $this->extensions);
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'extensions' => (array)$this->extensions,
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