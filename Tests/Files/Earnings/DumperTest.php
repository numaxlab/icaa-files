<?php

namespace NumaxLab\Icaa\Tests\Files\Earnings;

use Mockery;
use NumaxLab\Icaa\EarningsFile;
use NumaxLab\Icaa\Files\Earnings\Dumper;
use NumaxLab\Icaa\Records\Earnings\Box;
use NumaxLab\Icaa\Records\Earnings\CinemaTheatre;
use NumaxLab\Icaa\Records\Collection;
use NumaxLab\Icaa\Records\Earnings\Film;
use NumaxLab\Icaa\Records\Earnings\Session;
use NumaxLab\Icaa\Records\Earnings\SessionFilm;
use NumaxLab\Icaa\Records\Earnings\SessionScheduling;
use PHPUnit\Framework\TestCase;

class DumperTest extends TestCase
{
    /**
     * @var Dumper
     */
    protected $sut;

    /**
     * @var \Mockery\MockInterface
     */
    protected $fileMock;

    protected function setUp()
    {
        parent::setUp();

        $this->fileMock = Mockery::mock(EarningsFile::class);

        $this->fileMock->shouldReceive('box')
            ->andReturn(null);

        $this->fileMock->shouldReceive('cinemaTheatres')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('sessions')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('sessionsFilms')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('films')
            ->andReturn(new Collection());

        $this->fileMock->shouldReceive('sessionsScheduling')
            ->andReturn(new Collection());

        $this->sut = new Dumper(EarningsFile::EOL, $this->fileMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->sut = null;

        Mockery::close();
    }

    public function testDumpsString()
    {
        $this->prepareIcaaFileMock();

        $this->sut = new Dumper(EarningsFile::EOL, $this->fileMock);

        $dumpResult = 'testbox'.EarningsFile::EOL.
            'testcinematheatre'.EarningsFile::EOL.
            'testsession'.EarningsFile::EOL.
            'testsessionfilm'.EarningsFile::EOL.
            'testfilm'.EarningsFile::EOL.
            'testsessionscheduling';

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

        $this->fileMock = Mockery::mock(EarningsFile::class);

        $this->fileMock->shouldReceive('box')
            ->andReturn($boxDouble);

        $this->fileMock->shouldReceive('cinemaTheatres')
            ->andReturn(new Collection([$cinemaTheatreDouble]));

        $this->fileMock->shouldReceive('sessions')
            ->andReturn(new Collection([$sessionDouble]));

        $this->fileMock->shouldReceive('sessionsFilms')
            ->andReturn(new Collection([$sessionFilmDouble]));

        $this->fileMock->shouldReceive('films')
            ->andReturn(new Collection([$filmDouble]));

        $this->fileMock->shouldReceive('sessionsScheduling')
            ->andReturn(new Collection([$sessionSchedulingDouble]));
    }
}
