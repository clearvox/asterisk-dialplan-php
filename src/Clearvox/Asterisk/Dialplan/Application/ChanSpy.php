<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * This application is used to listen to the audio from an Asterisk channel.
 * This includes the audio  coming in and out of the channel being spied on.
 *
 * If the 'chanprefix' parameter is specified, only channels beginning with this
 * string will be spied upon.
 *
 * While spying, the following actions may be performed:
 * - Dialing '#' cycles the volume level.
 * - Dialing '*' will stop spying and look for another channel to spy on.
 * - Dialing a series of digits followed by '#' builds a channel name to append
 * to 'chanprefix'. For example, executing ChanSpy(Agent) and then dialing the
 * digits '1234#'  while spying will begin spying on the channel 'Agent/1234'.
 *
 * Note that this feature will be overridden if the 'd' option is used
 *
 * NOTE: The <X> option supersedes the three features above in that if a valid
 * single digit extension exists in the correct context ChanSpy will exit to
 * it. This also disables choosing a channel based on 'chanprefix' and a digit
 * sequence.
 * @category Clearvox
 * @package Four
 * @subpackage Dialplan\Application
 * @author Leon Rowland <leon@rowland.nl>
 */
class ChanSpy implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $chanPrefix;

    /**
     * @var array
     */
    protected $options = array();

    /**
     *
     * @param string $chanPrefix
     * @param array $options
     */
    public function __construct($chanPrefix = '', array $options = array())
    {
        $this->chanPrefix = $chanPrefix;
        $this->options    = $options;
    }

    /**
     * If the parameter is specified, only channels beginning with this string will be spied upon.
     *
     * @param string $chanPrefix
     * @return $this
     */
    public function setChanPrefix($chanPrefix)
    {
        $this->chanPrefix = $chanPrefix;
        return $this;
    }

    /**
     * @return string
     */
    public function getChanPrefix()
    {
        return $this->chanPrefix;
    }

    /**
     * b: Only spy on channels involved in a bridged call.
     *
     * B: Instead of whispering on a single channel barge in on both channels involved in the call.
     *
     * c(digit):
     * digit - Specify a DTMF digit that can be used to spy on the next available channel.
     *
     * d: Override the typical numeric DTMF functionality and instead use DTMF to switch between spy modes.
     * 4 - spy mode
     * 5 - whisper mode
     * 6 - barge mode
     *
     * e(ext): Enable *enforced* mode, so the spying channel can only monitor extensions whose name is in the
     * <ext> : delimited  list.
     *
     * E: Exit when the spied-on channel hangs up.
     *
     * g(grp):
     * grp - Only spy on channels in which one or more of the groups listed in <grp> matches one or more groups from
     * the ${SPYGROUP} variable set on the channel to be spied upon.
     * NOTE: both <grp> and ${SPYGROUP} can contain  either a single group or a colon-delimited list of groups, such
     * as 'sales:support:accounting'.
     *
     * n([mailbox][@context]): Say the name of the person being spied on if that person has recorded his/her name.
     * If a context is specified, then that voicemail context will be searched when retrieving the name, otherwise
     * the 'default' context be used when searching for the name (i.e. if SIP/1000 is the channel being spied on and
     * no mailbox is specified, then '1000' will be used when searching for the name).
     *
     * o: Only listen to audio coming from this channel.
     *
     * q: Don't play a beep when beginning to spy on a channel, or speak the selected channel name.
     *
     * r([basename]): Record the session to the monitor spool directory. An optional base for the filename may be
     * specified. The default is 'chanspy'.
     *
     * s: Skip the playback of the channel type (i.e. SIP, IAX, etc) when speaking the selected channel name.
     *
     * S: Stop when no more channels are left to spy on.
     *
     * v([value]): Adjust the initial volume in the range from '-4' to '4'. A negative value refers to a quieter
     * setting.
     *
     * w: Enable 'whisper' mode, so the spying channel can talk to the spied-on channel.
     *
     * W: Enable 'private whisper' mode, so the spying channel can talk to the spied-on channel but cannot listen to
     * that channel.
     *
     * x(digit):
     * digit - Specify a DTMF digit that can be used to exit the application while actively spying on a channel.
     * If there is no channel being spied on, the DTMF digit will be ignored.
     *
     * X: Allow the user to exit ChanSpy to a valid single digit numeric extension in the current context or the
     * context specified by the ${SPY_EXIT_CONTEXT} channel variable. The name of the last channel that was spied on
     * will be stored in the ${SPY_CHANNEL} variable.
     *
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'ChanSpy';
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

        if (isset($this->chanPrefix)) {
            $data .= $this->chanPrefix;
        }

        if ( ! empty($this->options)) {
            $data .= ',' . implode('', $this->options);
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
        return [
            'chan_prefix' => $this->chanPrefix,
            'options'     => $this->options
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