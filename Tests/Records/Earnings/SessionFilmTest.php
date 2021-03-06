<?php

namespace NumaxLab\Icaa\Tests\Records\Earnings;

use Carbon\Carbon;
use NumaxLab\Icaa\Records\Earnings\SessionFilm;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class SessionFilmTest extends TestCase
{
    public function testImplementsRecordInterface()
    {
        $sessionFilm = new SessionFilm(
            '123456',
            Carbon::now()->subDays(5),
            25
        );

        $this->assertInstanceOf(RecordInterface::class, $sessionFilm);
    }

    public function testConvertsToLine()
    {
        $sessionFilm = new SessionFilm(
            '123456',
            Carbon::now()->subDays(5),
            25
        );

        $line = $sessionFilm->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(28, Stringy::create($line)->length());
    }
}
