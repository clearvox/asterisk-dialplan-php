<?php
namespace Clearvox\Asterisk\Dialplan\Reader\Application;

use Clearvox\Asterisk\Dialplan\Application\ApplicationInterface;
use Clearvox\Asterisk\Dialplan\Application\UndeterminedApplication;

trait HasApplicationTrait
{
    /**
     * @param $applicationRaw
     * @param ApplicationReaderInterface[] $applications
     * @return ApplicationInterface
     */
    public function findApplication($applicationRaw, $applications = [])
    {
        foreach ($applications as $application) {
            $matches = [];

            if (preg_match($application->getMatchFormat(), $applicationRaw, $matches)) {
                return $application->getInstance($matches);
            }
        }

        // Standard expectation
        $format  = "/([A-Za-z]+)\((.+)\)/";
        $matches = [];

        preg_match($format, $applicationRaw, $matches);

        $name = (isset($matches[1]) ? $matches[1] : $matches);
        $data = (isset($matches[2]) ? $matches[2] : $applicationRaw);

        return new UndeterminedApplication($name, $data);
    }
}