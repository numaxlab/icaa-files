<?php

namespace NumaxLab\Icaa\Tests\Records;

use Mockery;
use NumaxLab\Icaa\Dumper;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\IcaaFile;
use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\Collection;
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

    /**
     * @var \Mockery\MockInterface
     */
    protected $fileMock;

    protected function setUp()
    {
        parent::setUp();

        $this->fileMock = Mockery::mock(IcaaFile::class);

        $this->fileMock->shouldReceive('getBox')
            ->andReturn(null);

        $this->fileMock->shouldReceive('getCinemaTheatres')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('getSessions')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('getSessionsFilms')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('getFilms')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('getSessionsScheduling')
            ->andReturn(new Collection());

        $this->sut = new Dumper(PHP_EOL, $this->fileMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->sut = null;

        Mockery::close();
    }

    public function testThrowsExceptionWhenMissingProperties()
    {
        $this->expectException(MissingPropertyException::class);

        $this->sut->dump();
    }

    public function testDumpsString()
    {
        $this->prepareIcaaFileMock();

        $this->sut = new Dumper(PHP_EOL, $this->fileMock);

        $dumpResult = 'testbox'.PHP_EOL.
            'testcinematheatre'.PHP_EOL.
            'testsession'.PHP_EOL.
            'testsessionfilm'.PHP_EOL.
            'testfilm'.PHP_EOL.
            'testsessionscheduling'.PHP_EOL;

        $dump = $this->sut->dump();

        $this->assertInternalType('string', $dump);
        $this->assertEquals($dumpResult, $dump);
    }

    protected function prepareIcaaFileMock()
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

        $this->fileMock = Mockery::mock(IcaaFile::class);

        $this->fileMock->shouldReceive('getBox')
            ->twice()
            ->andReturn($boxDouble);

        $this->fileMock->shouldReceive('getCinemaTheatres')
            ->twice()
            ->andReturn(new Collection([$cinemaTheatreDouble]));

        $this->fileMock->shouldReceive('getSessions')
            ->twice()
            ->andReturn(new Collection([$sessionDouble]));

        $this->fileMock->shouldReceive('getSessionsFilms')
            ->twice()
            ->andReturn(new Collection([$sessionFilmDouble]));

        $this->fileMock->shouldReceive('getFilms')
            ->twice()
            ->andReturn(new Collection([$filmDouble]));

        $this->fileMock->shouldReceive('getSessionsScheduling')
            ->twice()
            ->andReturn(new Collection([$sessionSchedulingDouble]));
    }
}
