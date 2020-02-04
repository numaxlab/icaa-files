<?php

namespace NumaxLab\Icaa\Tests\Records\Incidents;

use Carbon\Carbon;
use NumaxLab\Icaa\Records\Incidents\Header;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class HeaderTest extends TestCase
{
    public function testConvertsToLine()
    {
        $now = Carbon::now();

        $startDate = clone $now;
        $endDate = clone $now;

        $header = new Header(
            'ABC',
            $startDate->modify('this week'),
            $endDate->modify('this week +6 days')
        );

        $line = $header->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(16, Stringy::create($line)->length());
    }
}
