<?php

namespace NumaxLab\Icaa\Tests\Records;

use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\RecordInterface;
use NumaxLab\Icaa\Records\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Records\Session
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Session();
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
            ->setDatetime(Carbon::now())
            ->setFilmsQty(6)
            ->setTicketsQty(356)
            ->setEarnings(1345.60)
            ->setIncidentCode('ABC');

        $line = $this->sut->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(41, mb_strlen($line));
    }
}
