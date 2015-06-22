<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * Plays back given filenames (do not put extension of wav/alaw etc).
 * The playback command answer the channel if no options are specified.
 *
 * If the file is non-existant it will fail
 *
 * This application sets the following channel variable upon completion:
 * ${PLAYBACKSTATUS}: The status of the playback attempt as a text string.
 *  - SUCCESS
 *  - FAILED
 *
 * See Also: Background (application) -- for playing sound files that are
 * interruptible
 *
 * WaitExten (application) -- wait for digits from caller, optionally play music
 * on hold
 *
 * @author Leon Rowland <leon@rowland.nl>
 */
class Playback implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var array
     */
    protected $otherFiles = array();

    /**
     * @var bool|null
     */
    protected $skip;

    /**
     * @var bool|null
     */
    protected $noAnswer;

    public function __construct($filename, array $otherFiles = array())
    {
        $this->filename = $filename;
        $this->otherFiles = $otherFiles;
    }

    /**
     * Add a file to this playback.
     *
     * @param string $filename
     * @return $this
     */
    public function addFile($filename)
    {
        $this->otherFiles[] = $filename;
        return $this;
    }

    /**
     * If $skip is set to TRUE then "Do not play if not answered"
     *
     * @param boolean $skip
     * @return $this
     */
    public function setSkip($skip)
    {
        $this->skip = (bool) $skip;
        return $this;
    }

    /**
     * If $noAnswer is set to TRUE then "Playback without answering, otherwise the channel will
     * be answered before the sound is played."
     *
     * NOTE: Not all channel types support playing messages while still on hook.
     *
     * @param boolean $noAnswer
     * @return $this
     */
    public function setNoAnswer($noAnswer)
    {
        $this->noAnswer = (bool) $noAnswer;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'Playback';
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

        $data .= $this->filename;

        if ( ! empty($this->otherFiles)) {
            $data .= "&" . implode('&', $this->otherFiles);
        }

        $options = '';

        if ($this->skip) {
            $options .= ",skip";
        }

        if ($this->noAnswer) {
            $options .= ",noanswer";
        }

        return $data . $options;
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'filename'        => $this->filename,
            'other_filenames' => $this->otherFiles,
            'skip'            => $this->skip,
            'no_answer'       => $this->noAnswer
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
        return json_encode($this->toArray());
    }
}