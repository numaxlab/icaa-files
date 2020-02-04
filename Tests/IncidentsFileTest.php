<?php

namespace NumaxLab\Icaa\Tests;

use Carbon\Carbon;
use InvalidArgumentException;
use NumaxLab\Icaa\IncidentsFile;
use NumaxLab\Icaa\Records\Incidents\Header;
use NumaxLab\Icaa\Records\Incidents\TheatreIncidents;
use PHPUnit\Framework\TestCase;

class IncidentsFileTest extends TestCase
{
    public function testDumpsFile()
    {
        $incidentsFile = $this->setupIncidentsFile();

        $dump = $incidentsFile->dump();

        $this->assertInternalType('string', $dump);
    }

    public function testThatThrowsExceptionIfDumpWithoutDataSupplied()
    {
        $this->expectException(InvalidArgumentException::class);

        $incidentsFile = new IncidentsFile();

        $incidentsFile->dump();
    }

    private function setupIncidentsFile()
    {
        $incidentsFile = new IncidentsFile();

        $now = Carbon::now();

        $startDate = clone $now;
        $endDate = clone $now;

        $incidentsFile->setHeader(new Header(
            'ABC',
            $startDate->modify('this week'),
            $endDate->modify('this week +6 days')
        ));

        $incidentsFile->addTheatreIncidents(new TheatreIncidents(
            '123456',
            false,
            true,
            true,
            true,
            true,
            true,
            true,
            'MANTENIMENTO DEL PROYECTOR'
        ));

        $incidentsFile->addTheatreIncidents(new TheatreIncidents(
            '234567',
            true,
            true,
            true,
            true,
            true,
            true,
            true
        ));

        return $incidentsFile;
    }
}
