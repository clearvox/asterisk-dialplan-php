<?php
namespace Clearvox\Asterisk\Dialplan\Application;


/**
 * [Description]
 * If filename contains '%d', these characters will be replaced with a number
 * incremented by one each time the file is recorded.                 Use 'core
 * show file formats' to see the available formats on your system
 * User can press '#' to terminate the recording and continue to the next
 * priority.                 If the user hangs up during a recording, all data
 * will be lost and the application will terminate.
 * ${RECORDED_FILE}: Will be set to the final filename of the recording.
 * ${RECORD_STATUS}: This is the final status of the command
 * DTMF:A terminating DTMF was received ('#' or '*', depending upon
 * option 't')
 * SILENCE:The maximum silence occurred in the recording.
 * SKIP:The line was not yet answered and the 's' option was specified.
 * TIMEOUT:The maximum length was reached.
 * HANGUP:The channel was hung up.
 * ERROR:An unrecoverable error occurred, which resulted in a WARNING
 * to the logs.
 *
 * [Syntax]
 * Record(filename.format[,silence[,maxduration[,options]]])
 *
 * [Arguments]
 * format
 * Is the format of the file type to be recorded (wav, gsm, etc).
 * silence
 * Is the number of seconds of silence to allow before returning.
 * maxduration
 * Is the maximum recording duration in seconds. If missing
 * or 0 there is no maximum.
 * options
 */
class Record implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * The filename to record to including extension
     *
     * @var string
     */
    protected $filename;

    /**
     * @var int
     */
    protected $silence;

    /**
     * @var int
     */
    protected $maxDuration;

    /**
     * @var array
     */
    protected $options = array();

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return mixed
     */
    public function getSilence()
    {
        return $this->silence;
    }

    /**
     * @param mixed $silence
     * @return $this
     */
    public function setSilence($silence)
    {
        $this->silence = $silence;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMaxDuration()
    {
        return $this->maxDuration;
    }

    /**
     * @param mixed $maxDuration
     * @return $this
     */
    public function setMaxDuration($maxDuration)
    {
        $this->maxDuration = $maxDuration;
        return $this;
    }

    /**
     * a: Append to existing recording rather than replacing.
     *
     * n: Do not answer, but record anyway if line not yet answered.
     *
     * q: quiet (do not play a beep tone).
     *
     * s: skip recording if the line is not yet answered.
     *
     * t: use alternate '*' terminator key (DTMF) instead of default '#'
     *
     * x: Ignore all terminator keys (DTMF) and keep recording until hangup.
     *
     * k: Keep recorded file upon hangup.
     *
     * y: Terminate recording if *any* DTMF digit is received.
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
        return 'Record';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $data = $this->filename;

        if( ! empty($this->silence)) {
            $data .= ',' . $this->silence;
        } elseif ( ! empty($this->maxDuration) || !empty($this->options)) {
            $data .= ',';
        }

        if( ! empty($this->maxDuration)) {
            $data .= ',' . $this->maxDuration;
        } elseif ( ! empty($this->options)){
            $data .= ',';
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
            'filename' => $this->filename,
            'silence' => $this->silence,
            'max_duration' => $this->maxDuration,
            'options' => $this->options,
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