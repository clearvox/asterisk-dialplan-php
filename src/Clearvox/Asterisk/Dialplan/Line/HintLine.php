<?php
namespace Clearvox\Asterisk\Dialplan\Line;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;

class HintLine implements LineInterface
{
    protected $pattern;

    protected $peers = array();

    public function __construct(string $pattern = null, array $peers = array())
    {
        $this->pattern = $pattern;
        $this->peers   = $peers;
    }

    /**
     * Add peers to this hint.
     */
    public function addPeer(string $peerString): HintLine
    {
        $this->peers[] = $peerString;
        return $this;
    }

    public function getPeers(): array
    {
        return $this->peers;
    }

    /**
     * Get the pattern for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Get the priority for this line. There is no guarantee that
     * the response string wouldn't be empty.
     */
    public function getPriority(): ?string
    {
        return null;
    }

    /**
     * Get the application associated with this line.
     */
    public function getApplication(): ?ApplicationInterface
    {
        return null;
    }

    /**
     * Turn this implemented Line into a string representation.
     */
    public function toString(): string
    {
        return "exten => " . $this->pattern . ',hint,' . implode('&', $this->peers);
    }
}