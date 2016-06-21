<?php
namespace Clearvox\Asterisk\Dialplan\Reader;

use Clearvox\Asterisk\Dialplan\Reader\Application\ApplicationReaderInterface;
use Clearvox\Asterisk\Dialplan\Reader\Application\NoOpReader;
use Clearvox\Asterisk\Dialplan\Reader\Line\ExtenLineReader;
use Clearvox\Asterisk\Dialplan\Reader\Line\LineReaderInterface;

class ReaderFactory
{
    /**
     * @var ApplicationReaderInterface[]
     */
    protected $applications = [];

    /**
     * @var LineReaderInterface[]
     */
    protected $lines = [];

    public function __construct()
    {
        $this->applications[] = new NoOpReader();
        $this->lines[]        = new ExtenLineReader($this->applications);
    }

    /**
     * Create an instance of reader with all the known line readers and
     * application readers.
     *
     * @return Reader
     */
    public function create()
    {
        return new Reader($this->lines);
    }
}