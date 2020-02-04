<?php

namespace NumaxLab\Icaa\Tests\Records\Incidents;

use NumaxLab\Icaa\Records\Incidents\TheatreIncidents;
use PHPUnit\Framework\TestCase;

class TheatreIncidentsTest extends TestCase
{
    public function testConvertsToLine()
    {
        $theatreIncidents = new TheatreIncidents(
            '123456',
            false,
            true,
            true,
            true,
            true,
            true,
            true,
            'MANTENIMENTO DEL PROYECTOR'
        );

        $line = $theatreIncidents->toLine();

        $this->assertInternalType('string', $line);
    }
}
