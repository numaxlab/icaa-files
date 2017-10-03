<?php

namespace NumaxLab\Icaa\Tests\Records;

use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class CinemaTheatreTest extends TestCase
{
    public function testImplementsRecordInterface()
    {
        $cinemaTheatre = new CinemaTheatre('123456', 'Test cinema theatre');

        $this->assertInstanceOf(RecordInterface::class, $cinemaTheatre);
    }

    public function testConvertsToLine()
    {
        $cinemaTheatre = new CinemaTheatre('123456', 'Test cinema theatre');

        $line = $cinemaTheatre->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(43, Stringy::create($line)->length());
    }

    public function testTrimsTooLongName()
    {
        $cinemaTheatre = new CinemaTheatre(
            '123456',
            'Test cinema with a long name that should be trimmed'
        );

        $line = $cinemaTheatre->toLine();

        $this->assertEquals(43, Stringy::create($line)->length());
    }
}
