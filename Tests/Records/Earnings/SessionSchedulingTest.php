<?php

namespace NumaxLab\Icaa\Tests\Records\Earnings;

use Carbon\Carbon;
use NumaxLab\Icaa\Records\Earnings\SessionScheduling;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class SessionSchedulingTest extends TestCase
{
    public function testImplementsRecordInterface()
    {
        $sessionScheduling = new SessionScheduling(
            '123456',
            Carbon::now()->subDays(5),
            1
        );

        $this->assertInstanceOf(RecordInterface::class, $sessionScheduling);
    }

    public function testConvertsToLine()
    {
        $sessionScheduling = new SessionScheduling(
            '123456',
            Carbon::now()->subDays(5),
            2
        );

        $line = $sessionScheduling->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(21, Stringy::create($line)->length());
    }
}
