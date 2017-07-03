<?php

namespace NumaxLab\Icaa\Tests\Records;

use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\CinemaTheatre;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;

class CinemaTheatreTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Records\CinemaTheatre
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new CinemaTheatre();
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->sut = NULL;
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
            ->setName('Test cinema theatre 1');

        $line = $this->sut->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(43, mb_strlen($line));
    }

    public function testTrimsTooLongName()
    {
        $this->sut->setCode('123')
            ->setName('Test cinema with a long name that should be trimmed');

        $line = $this->sut->toLine();

        $this->assertEquals(43, mb_strlen($line));
    }
}
