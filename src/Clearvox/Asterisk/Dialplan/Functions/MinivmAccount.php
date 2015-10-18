<?php
namespace Clearvox\Asterisk\Dialplan\Functions;

class MinivmAccount implements FunctionInterface
{
    use StandardFunctionTrait;

    protected $account;

    public function __construct($account)
    {
        $this->account = $account;
    }

    /**
     * Return the boolean value if the account is a valid
     * voicemail box or not.
     *
     * @return string
     */
    public function requestHasAccount()
    {
        return $this->getRaw('hasaccount');
    }

    /**
     * Return the set fullname on the voicemail box.
     *
     * @return string
     */
    public function requestFullName()
    {
        return $this->getRaw('fullname');
    }

    /**
     * Return the set email on the voicemail box.
     *
     * @return string
     */
    public function requestEmail()
    {
        return $this->getRaw('email');
    }

    /**
     * Return the set pager on the voicemail box.
     *
     * @return string
     */
    public function requestPager()
    {
        return $this->getRaw('pager');
    }

    /**
     * Return the set emplate for this voicemail box.
     *
     * @return string
     */
    public function requestETemplate()
    {
        return $this->getRaw('etemplate');
    }

    /**
     * Return the set ptemplate for this voicemail box.
     *
     * @return string
     */
    public function requestPTemplate()
    {
        return $this->getRaw('ptemplate');
    }

    /**
     * Return the set account code for this voicemail
     * account box.
     *
     * @return string
     */
    public function requestAccountCode()
    {
        return $this->getRaw('accountcode');
    }

    /**
     * Return the set path on the voicemail box.
     *
     * @return string
     */
    public function requestPath()
    {
        return $this->getRaw('path');
    }

    /**
     * Return the set pin code on the voicemail box.
     *
     * @return string
     */
    public function requestPinCode()
    {
        return $this->getRaw('pincode');
    }

    /**
     * Return the set timezone on the voicemail box.
     *
     * @return string
     */
    public function requestTimeZone()
    {
        return $this->getRaw('timezone');
    }

    /**
     * Return the set language on the voicemail box.
     *
     * @return string
     */
    public function requestLanguage()
    {
        return $this->getRaw('language');
    }

    /**
     * Request a custom value in the setvar of the
     * defined voicemail box.
     *
     * @param string $custom
     * @return string
     */
    public function requestCustom($custom)
    {
        return $this->getRaw($custom);
    }

    /**
     * Returns the function in its full string representation.
     *
     * @return string
     */
    public function toString()
    {
        return $this->requestHasAccount();
    }

    /**
     * Return the full function definition with the type of data you want
     * from the MINIVMACCOUNT function.
     *
     * @param string $type
     * @return string
     */
    protected function getRaw($type)
    {
        return 'MINIVMACCOUNT(' . $this->account . ':' . $type . ')';
    }
}