<?php

namespace NumaxLab\Icaa\Tests\Records;

use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class FilmTest extends TestCase
{
    public function testImplementsRecordInterface()
    {
        $film = new Film(
            '123456',
            25,
            '1458',
            'Film title',
            '4567',
            'Distributor name',
            '4',
            'P',
            '4',
            '1'
        );

        $this->assertInstanceOf(RecordInterface::class, $film);
    }

    public function testConvertsToLine()
    {
        $film = new Film(
            '123456',
            25,
            '1458',
            'Film title',
            '4567',
            'Distributor name',
            '4',
            'P',
            '4',
            '1'
        );

        $line = $film->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(146, Stringy::create($line)->length());
    }

    public function testTrimsTooLongTexts()
    {
        $film = new Film(
            '123456',
            25,
            '1458',
            'Test film title with a long name that should be trimmed',
            '4567',
            'Test distributor name with a long name that should be trimmed',
            '4',
            'P',
            '4',
            '1'
        );

        $line = $film->toLine();

        $this->assertEquals(146, Stringy::create($line)->length());
    }
}
