<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class SIPAddHeader implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $header;

    /**
     * @var string
     */
    protected $content;

    /**
     * Add a SIP header to the outbound call.
     *
     * @param string $header
     * @param string $content
     */
    public function __construct($header, $content)
    {
        $this->header  = $header;
        $this->content = $content;
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
     * Get the header content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'SIPAddHeader';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->header . ': ' . $this->content;
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
            'content' => $this->content,
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