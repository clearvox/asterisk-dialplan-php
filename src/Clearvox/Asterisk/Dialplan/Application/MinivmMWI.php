<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class MinivmMWI implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $account;

    /**
     * @var int
     */
    protected $urgent;

    /**
     * @var int
     */
    protected $new;

    /**
     * @var int
     */
    protected $old;

    public function __construct($account, $urgent, $new, $old)
    {
        $this->account = $account;
        $this->urgent = $urgent;
        $this->new = $new;
        $this->old = $old;
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return mixed
     */
    public function getUrgent()
    {
        return $this->urgent;
    }

    /**
     * @return mixed
     */
    public function getNew()
    {
        return $this->new;
    }

    /**
     * @return mixed
     */
    public function getOld()
    {
        return $this->old;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'MinivmMWI';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->account;

        $data .= ',' . $this->urgent;
        $data .= ',' . $this->new;
        $data .= ',' . $this->old;

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
            'account' => $this->account,
            'urgent' => $this->urgent,
            'new' => $this->new,
            'old' => $this->old
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