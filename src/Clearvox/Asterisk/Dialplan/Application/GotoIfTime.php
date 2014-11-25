<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class GotoIfTime implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $times;

    /**
     * @var string
     */
    protected $weekdays;

    /**
     * @var string
     */
    protected $mdays;

    /**
     * @var string
     */
    protected $months;

    /**
     * @var string|null
     */
    protected $timezone;

    /**
     * @var Go
     */
    protected $true;

    /**
     * @var Go
     */
    protected $false;

    public function __construct($times, $weekdays, $mdays, $months, $timezone = null, Go $true = null, Go $false = null)
    {
        $this->times    = $times;
        $this->weekdays = $weekdays;
        $this->mdays    = $mdays;
        $this->months   = $months;
        $this->timezone = $timezone;
        $this->true     = $true;
        $this->false    = $false;
    }

    /**
     * @return \Clearvox\Asterisk\Dialplan\Application\Go
     */
    public function getFalse()
    {
        return $this->false;
    }

    /**
     * @return string
     */
    public function getMdays()
    {
        return $this->mdays;
    }

    /**
     * @return string
     */
    public function getMonths()
    {
        return $this->months;
    }

    /**
     * @return string
     */
    public function getTimes()
    {
        return $this->times;
    }

    /**
     * @return null|string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return \Clearvox\Asterisk\Dialplan\Application\Go
     */
    public function getTrue()
    {
        return $this->true;
    }

    /**
     * @return string
     */
    public function getWeekdays()
    {
        return $this->weekdays;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'GotoIfTime';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->times . ',' . $this->weekdays . ',' . $this->mdays . ',' . $this->months . ',';

        if (isset($this->timezone)) {
            $data .= $this->timezone;
        }

        $data .= '?';

        if (isset($this->true)) {
            $data .= $this->true->getData() . ':';

            if (isset($this->false)) {
                $data .= $this->false->getData();
            }
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
        return array(
            'times'    => $this->times,
            'weekdays' => $this->weekdays,
            'mdays'    => $this->mdays,
            'months'   => $this->months,
            'timezone' => $this->timezone,
            'true'     => $this->true->toArray(),
            'false'    => $this->false->toArray()
        );
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