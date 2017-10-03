<?php

namespace NumaxLab\Icaa\Tests;

use Carbon\Carbon;
use InvalidArgumentException;
use NumaxLab\Icaa\IcaaFile;
use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionFilm;
use NumaxLab\Icaa\Records\SessionScheduling;
use PHPUnit\Framework\TestCase;

class IcaaFileTest extends TestCase
{
    public function testDumpsFile()
    {
        $icaaFile = $this->setupIcaaFile();

        $dump = $icaaFile->dump();

        $this->assertInternalType('string', $dump);
    }

    public function testThatThrowsExceptionIfDumpWithoutDataSupplied()
    {
        $this->expectException(InvalidArgumentException::class);

        $icaaFile = new IcaaFile();

        $icaaFile->dump();
    }

    public function testUpdatesBox()
    {
        $icaaFile = $this->setupIcaaFile();

        $icaaFile->dump();

        $box = $icaaFile->box();

        $this->assertEquals(6, $box->getFileLinesQty());
        $this->assertEquals(1, $box->getSessionsQty());
        $this->assertEquals(5, $box->getTicketsQty());
        $this->assertEquals(22.5, $box->getEarnings());
    }

    private function setupIcaaFile()
    {
        $icaaFile = new IcaaFile();

        $icaaFile->setBox(new Box(
            Box::FILE_TYPE_REGULAR,
            'ABC',
            Carbon::now()->subDays(7),
            Carbon::now()
        ));

        $icaaFile->addCinemaTheatre(new CinemaTheatre(
            '123456',
            'Test cinema theatre'
        ));

        $icaaFile->addSession(new Session(
            '123456',
            Carbon::now()->subDays(2),
            1,
            5,
            22.5,
            '000'
        ));

        $icaaFile->addSessionFilm(new SessionFilm(
            '123456',
            Carbon::now()->subDays(2),
            10
        ));

        $icaaFile->addFilm(new Film(
            '123456',
            10,
            '12876',
            'Test film',
            '987',
            'Test distributor',
            '4',
            'P',
            '4',
            '1'
        ));

        $icaaFile->addSessionScheduling(new SessionScheduling(
            '123456',
            Carbon::now()->subDays(2),
            1
        ));

        return $icaaFile;
    }
}
