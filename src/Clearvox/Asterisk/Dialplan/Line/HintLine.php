<?php
namespace Clearvox\Asterisk\Dialplan\Line;

class HintLine implements LineInterface
{
    protected $pattern;

    protected $peers = array();

    public function __construct($pattern, array $peers = array())
    {
        $this->pattern = $pattern;
        $this->peers   = $peers;
    }

    /**
     * Add peers to this hint.
     *
     * @param string $peerString
     * @return $this
     */
    public function addPeer($peerString)
    {
        $this->peers[] = $peerString;
        return $this;
    }

    /**
     * @return array
     */
    public function getPeers()
    {
        return $this->peers;
    }

    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     *
     * @return string
     */
    public function getPriority()
    {
        return 'hint';
    }

    /**
     * Get the application associated with this line.
     *
     * @return \Clearvox\Asterisk\Dialplan\Application\ApplicationInterface
     */
    public function getApplication()
    {
        return null;
    }

    /**
     * Turn this implemented Line into a string representation.
     *
     * @return string
     */
    public function toString()
    {
        return "exten => " . $this->pattern . ',hint,' . implode('&', $this->peers);
    }
}