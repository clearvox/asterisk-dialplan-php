<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class GosubIf implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $condition;

    /**
     * @var Go|null
     */
    protected $true;

    /**
     * @var Go|null
     */
    protected $false;

    public function __construct($condition, Go $true = null, Go $false = null)
    {
        $this->condition = $condition;
        $this->true      = $true;
        $this->false     = $false;
    }

    /**
     * @return string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return Go|null
     */
    public function getFalse()
    {
        return $this->false;
    }

    /**
     * @return Go|null
     */
    public function getTrue()
    {
        return $this->true;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'GosubIf';
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

        $data .= $this->condition . '?';

        if (isset($this->true)) {
            $data .= $this->true->getData();
        }

        if (isset($this->false)) {
            $data .= ':' . $this->false->getData();
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
        $array = array(
            'condition' => $this->condition
        );

        if(isset($this->true)) {
            $array['true'] = $this->true;
        }

        if(isset($this->false)) {
            $array['false'] = $this->false;
        }

        return $array;
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