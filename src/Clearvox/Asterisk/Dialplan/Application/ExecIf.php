<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class ExecIf implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * @var string
     */
    protected $expression;

    /**
     * @var ApplicationInterface
     */
    protected $true;

    /**
     * @var ApplicationInterface|null
     */
    protected $false;

    public function __construct(
        $expression,
        ApplicationInterface $true,
        ApplicationInterface $false = null
    ) {
        $this->expression = $expression;
        $this->true       = $true;
        $this->false      = $false;
    }

    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * Get the application that should run when this expression is evaluated
     * to true.
     *
     * @return ApplicationInterface
     */
    public function getTrue()
    {
        return $this->true;
    }

    /**
     * Set the false application for the expression.
     *
     * @param ApplicationInterface $false
     */
    public function setFalse(ApplicationInterface $false)
    {
        $this->false = $false;
    }

    /**
     * Get the false application for this ExecIf. There is a chance that this is null
     * from not being set.
     *
     * @return ApplicationInterface|null
     */
    public function getFalse()
    {
        return $this->false;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'ExecIf';
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        // Variables
        $expression = $this->expression;
        $trueString = $this->true->toString();

        // Prepare the data
        $data = "$expression?$trueString";

        // Add false if its set
        if (!is_null($this->false)) {
            $falseString = $this->false->toString();
            $data .= ":$falseString";
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
        $data = [
            'expression' => $this->expression,
            'true' => $this->true->toArray(),
        ];

        if (!is_null($this->false)) {
            $data['false'] = $this->false->toArray();
        }

        return $data;
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