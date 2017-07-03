<?php

namespace NumaxLab\Icaa\Tests\Records;

use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\RecordInterface;
use NumaxLab\Icaa\Records\SessionFilm;
use PHPUnit\Framework\TestCase;

class SessionFilmTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Records\SessionFilm
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new SessionFilm();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->sut = null;
    }

    public function testImplementsRecordInterface()
    {
        $this->assertInstanceOf(RecordInterface::class, $this->sut);
    }

    public function testThrowsExceptionWhenMissingProperties()
    {
        $this->expectException(MissingPropertyException::class);

        $this->sut->toLine();
    }

    public function testConvertsToLine()
    {
        $this->sut->setCinemaTheatreCode('123')
            ->setSessionDatetime(Carbon::now())
            ->setFilmId(5);

        $line = $this->sut->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(28, mb_strlen($line));
    }
}
