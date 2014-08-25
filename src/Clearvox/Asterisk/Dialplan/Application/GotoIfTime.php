<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class GotoIfTime implements ApplicationInterface
{
    use StandardApplicationTrait;

    protected $times;

    protected $weekdays;

    protected $mdays;

    protected $months;

    protected $timezone;

    protected $true;

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
}