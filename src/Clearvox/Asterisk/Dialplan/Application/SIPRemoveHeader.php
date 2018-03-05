<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class SIPRemoveHeader implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $header;

    /**
     * Remove a SIP header to the outbound call.
     *
     * @param string $header
     * @param string $content
     */
    public function __construct($header)
    {
        $this->header  = $header;
    }

    /**
     * Get the header name
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'SIPRemoveHeader';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->header;
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'header'  => $this->header,
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