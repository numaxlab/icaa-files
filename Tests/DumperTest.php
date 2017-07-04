<?php

namespace NumaxLab\Icaa\Tests\Records;

use Mockery;
use NumaxLab\Icaa\Dumper;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\Session;
use NumaxLab\Icaa\Records\SessionFilm;
use NumaxLab\Icaa\Records\SessionScheduling;
use PHPUnit\Framework\TestCase;

class DumperTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Dumper
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Dumper();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->sut = null;
    }

    public function testThrowsExceptionWhenMissingProperties()
    {
        $this->expectException(MissingPropertyException::class);

        $this->sut->dump();
    }

    public function testDumpsString()
    {
        $boxDouble = Mockery::mock(Box::class);
        $boxDouble->shouldReceive('toLine')
            ->once()
            ->andReturn('testbox');

        $cinemaTheatreDouble = Mockery::mock(CinemaTheatre::class);
        $cinemaTheatreDouble->shouldReceive('toLine')
            ->once()
            ->andReturn('testcinematheatre');

        $sessionDouble = Mockery::mock(Session::class);
        $sessionDouble->shouldReceive('toLine')
            ->once()
            ->andReturn('testsession');

        $sessionFilmDouble = Mockery::mock(SessionFilm::class);
        $sessionFilmDouble->shouldReceive('toLine')
            ->once()
            ->andReturn('testsessionfilm');

        $filmDouble = Mockery::mock(Film::class);
        $filmDouble->shouldReceive('toLine')
            ->once()
            ->andReturn('testfilm');

        $sessionSchedulingDouble = Mockery::mock(SessionScheduling::class);
        $sessionSchedulingDouble->shouldReceive('toLine')
            ->once()
            ->andReturn('testsessionscheduling');

        $dumpResult = 'testbox'.PHP_EOL.
            'testcinematheatre'.PHP_EOL.
            'testsession'.PHP_EOL.
            'testsessionfilm'.PHP_EOL.
            'testfilm'.PHP_EOL.
            'testsessionscheduling'.PHP_EOL;

        $this->sut->setBox($boxDouble)
            ->addCinemaTheatre($cinemaTheatreDouble)
            ->addSession($sessionDouble)
            ->addSessionFilm($sessionFilmDouble)
            ->addFilm($filmDouble)
            ->addSessionScheduling($sessionSchedulingDouble);

        $dump = $this->sut->dump();

        $this->assertInternalType('string', $dump);
        $this->assertEquals($dumpResult, $dump);
    }
}
