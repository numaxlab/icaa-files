<?php

namespace NumaxLab\Icaa\Tests;

use Carbon\Carbon;
use InvalidArgumentException;
use NumaxLab\Icaa\EarningsFile;
use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionFilm;
use NumaxLab\Icaa\Records\SessionScheduling;
use PHPUnit\Framework\TestCase;

class EarningsFileTest extends TestCase
{
    public function testDumpsFile()
    {
        $earningsFile = $this->setupEarningsFile();

        $dump = $earningsFile->dump();

        $this->assertInternalType('string', $dump);
    }

    public function testThatThrowsExceptionIfDumpWithoutDataSupplied()
    {
        $this->expectException(InvalidArgumentException::class);

        $earningsFile = new EarningsFile();

        $earningsFile->dump();
    }

    public function testUpdatesBox()
    {
        $earningsFile = $this->setupEarningsFile();

        $earningsFile->dump();

        $box = $earningsFile->box();

        $this->assertEquals(6, $box->getFileLinesQty());
        $this->assertEquals(1, $box->getSessionsQty());
        $this->assertEquals(5, $box->getTicketsQty());
        $this->assertEquals(22.5, $box->getEarnings());
    }

    private function setupEarningsFile()
    {
        $earningsFile = new EarningsFile();

        $earningsFile->setBox(new Box(
            Box::FILE_TYPE_REGULAR,
            'ABC',
            Carbon::now()->subDays(7),
            Carbon::now()
        ));

        $earningsFile->addCinemaTheatre(new CinemaTheatre(
            '123456',
            'Test cinema theatre'
        ));

        $earningsFile->addSession(new Session(
            '123456',
            Carbon::now()->subDays(2),
            1,
            5,
            22.5,
            '000'
        ));

        $earningsFile->addSessionFilm(new SessionFilm(
            '123456',
            Carbon::now()->subDays(2),
            10
        ));

        $earningsFile->addFilm(new Film(
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

        $earningsFile->addSessionScheduling(new SessionScheduling(
            '123456',
            Carbon::now()->subDays(2),
            1
        ));

        return $earningsFile;
    }
}
