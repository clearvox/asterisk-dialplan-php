<?php
namespace Clearvox\Asterisk\Dialplan\Application;

/**
 * This application will play the given list of files *(do not put extension)*
 * while waiting for an extension to be dialed by the calling channel. To continue
 * waiting for digits after this application has finished playing files, the
 * 'WaitExten' application should be used.
 *
 * If one of the requested sound files does not exist, call processing will
 * be terminated.
 *
 * This application sets the following channel variable upon completion:
 *      ${BACKGROUNDSTATUS}: The status of the background attempt as a text string.
 *          SUCCESS
 *          FAILED
 *
 * @category Clearvox
 * @package Asterisk/Dialplan
 * @subpackage Application
 * @author Leon Rowland <leon@rowland.nl>
 */
class BackGround implements ApplicationInterface
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

    /**
     * @var bool|null
     */
    protected $onlyMatch;

    /**
     * @var string|null
     */
    protected $lang;

    /**
     * @var string|null
     */
    protected $context;

    public function __construct($filename, array $otherFiles = array())
    {
        $this->filename = $filename;
        $this->otherFiles = $otherFiles;
    }

    /**
     * Add a file to this playback
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
     * Causes the playback of the message to be skipped if the channel
     * is not in the 'up' state (i.e. it hasn't been answered yet). If this
     * happens, the application will return immediately.
     *
     * @param boolean $skip
     * @return $this
     */
    public function setSkip($skip)
    {
        $this->skip = (bool)$skip;
        return $this;
    }

    /**
     * Don't answer the channel before playing the files.
     *
     * @param boolean $noAnswer
     * @return $this
     */
    public function setNoAnswer($noAnswer)
    {
        $this->noAnswer = (bool)$noAnswer;
        return $this;
    }

    /**
     * Only break if a digit hit matches a one digit extension in the
     * destination context.
     *
     * @param boolean $onlyMatch
     * @return $this
     */
    public function setOnlyMatch($onlyMatch)
    {
        $this->onlyMatch = (bool)$onlyMatch;
        return $this;
    }

    /**
     * Explicitly specifies which language to attempt to use for the
     * requested sound files.
     *
     * @param string $lang
     * @return $this
     */
    public function setLangOverride($lang)
    {
        $this->lang = $lang;
        return $this;
    }

    /**
     * This is the dialplan context that this application will use when
     * exiting to a dialed extension.
     *
     * @param string $context
     * @return $this
     */
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'BackGround';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        $line = array();

        if(!empty($this->context)) {
            $line[0] = $this->context;
            $line[1] = null;
            $line[2] = null;
        }

        if(!empty($this->lang)) {
            $line[1] = $this->lang;
            $line[2] = null;
        }

        $options = [];

        if ($this->skip) {
            $options[] = 's';
        }

        if ($this->noAnswer) {
            $options[] = 'n';
        }

        if ($this->onlyMatch) {
            $options[] = 'm';
        }

        if(!empty($options)) {
            $line[2] = implode('', $options);
        }

        $file = $this->filename;

        if(!empty($this->otherFiles)) {
            $file .= "&" . implode('&', $this->otherFiles);
        }

        $line[3] = $file;

        return implode(',', array_reverse($line));
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'filename'      => (string)$this->filename,
            'other_files'   => (array)$this->otherFiles,
            'skip'          => (boolean)$this->skip,
            'no_answer'     => (boolean)$this->noAnswer,
            'only_match'    => (boolean)$this->onlyMatch,
            'lang_override' => (string)$this->lang,
            'context'       => (string)$this->context
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