<?php

namespace NumaxLab\Icaa\Tests\Records\Earnings;

use Carbon\Carbon;
use NumaxLab\Icaa\Records\Earnings\Session;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class SessionTest extends TestCase
{
    public function testImplementsRecordInterface()
    {
        $session = new Session(
            '123456',
            Carbon::now()->subDays(5),
            1,
            30,
            250.30,
            '000'
        );

        $this->assertInstanceOf(RecordInterface::class, $session);
    }

    public function testConvertsToLine()
    {
        $session = new Session(
            '123456',
            Carbon::now()->subDays(5),
            2,
            145,
            1345.65,
            '000'
        );

        $line = $session->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(41, Stringy::create($line)->length());
    }
}
