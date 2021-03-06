<?php

namespace NumaxLab\Icaa\Tests\Records\Earnings;

use Carbon\Carbon;
use InvalidArgumentException;
use NumaxLab\Icaa\Records\Earnings\Box;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class BoxTest extends TestCase
{
    public function testImplementsRecordInterface()
    {
        $box = new Box(
            Box::FILE_TYPE_REGULAR,
            '123',
            Carbon::now()->subDays(7),
            Carbon::now()
        );

        $this->assertInstanceOf(RecordInterface::class, $box);
    }

    public function testConvertsToLine()
    {
        $box = new Box(
            Box::FILE_TYPE_REGULAR,
            '123',
            Carbon::now()->subDays(7),
            Carbon::now()
        );

        $line = $box->toLine();

        $this->assertIsString($line);
        $this->assertEquals(56, Stringy::create($line)->length());
    }

    public function testThrowsExceptionWhenInvalidFileType()
    {
        $this->expectException(InvalidArgumentException::class);

        new Box(
            'AB',
            '123',
            Carbon::now()->subDays(7),
            Carbon::now()
        );
    }
}
