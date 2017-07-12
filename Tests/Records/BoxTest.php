<?php

namespace NumaxLab\Icaa\Tests\Records;

use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\InvalidFormatException;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\Box;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;
use Stringy\Stringy;

class BoxTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Records\Box
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Box(Box::FILE_TYPE_REGULAR);
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
        $this->sut->setCode('123')
            ->setLastScheduledFileSentAt(Carbon::now()->subDays(7))
            ->setCurrentFileSentAt(Carbon::now())
            ->setFileLinesQty(10)
            ->setSessionsQty(2)
            ->setTicketsQty(100)
            ->setEarnings(2050.50);

        $line = $this->sut->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(56, Stringy::create($line)->length());
    }

    public function testThrowsExceptionWhenInvalidFileType()
    {
        $this->expectException(InvalidFormatException::class);

        new Box('AB');
    }
}
