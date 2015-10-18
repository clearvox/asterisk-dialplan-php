<?php
namespace Clearvox\Asterisk\Dialplan\Application;

class WhileApplication implements ApplicationInterface
{
    use StandardApplicationTrait;

    /**
     * Start a While Loop.  Execution will return to this point when 'EndWhile()' is
     * called until expr is no longer true.
     *
     * @param string $expression
     */
    public function __construct($expression)
    {
        $this->expression = $expression;
    }

    /**
     * Should return the name of the application
     *
     * @return string
     */
    public function getName()
    {
        return 'While';
    }

    /**
     * Return the set expression that the while loop will continue
     * until it doesn't return 1.
     *
     * @return string
     */
    public function getExpression()
    {
        return $this->expression;
    }

    /**
     * Should return the AppData. AppData is the string contents
     * between the () of the App.
     *
     * @return string
     */
    public function getData()
    {
        return $this->expression;
    }

    /**
     * Turns this application into an Array
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'expression' => $this->expression,
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