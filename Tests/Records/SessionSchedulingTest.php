<?php

namespace NumaxLab\Icaa\Tests\Records;

use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\RecordInterface;
use NumaxLab\Icaa\Records\SessionScheduling;
use PHPUnit\Framework\TestCase;

class SessionSchedulingTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Records\SessionScheduling
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new SessionScheduling();
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
            ->setSessionsQty(25);

        $line = $this->sut->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(21, mb_strlen($line));
    }
}
