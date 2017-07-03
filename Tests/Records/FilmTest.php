<?php

namespace NumaxLab\Icaa\Tests\Records;

use NumaxLab\Icaa\Exceptions\MissingPropertyException;
use NumaxLab\Icaa\Records\Film;
use NumaxLab\Icaa\Records\RecordInterface;
use PHPUnit\Framework\TestCase;

class FilmTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Records\Film
     */
    protected $sut;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Film();
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
            ->setId(5)
            ->setClassificationRecordCode('ABC')
            ->setTitle('Film title')
            ->setDistributorCode('456')
            ->setDistributorName('Distributor name')
            ->setOriginalVersionCode('G')
            ->setLangVersionCode('G')
            ->setCaptionsLangCode('G')
            ->setProjectionFormat('D');

        $line = $this->sut->toLine();

        $this->assertInternalType('string', $line);
        $this->assertEquals(146, mb_strlen($line));
    }

    public function testTrimsTooLongTexts()
    {
        $this->sut->setCinemaTheatreCode('123')
            ->setId(5)
            ->setClassificationRecordCode('ABC')
            ->setTitle('Test film title with a long name that should be trimmed')
            ->setDistributorCode('456')
            ->setDistributorName('Test distributor name with a long name that should be trimmed')
            ->setOriginalVersionCode('G')
            ->setLangVersionCode('G')
            ->setCaptionsLangCode('G')
            ->setProjectionFormat('D');

        $line = $this->sut->toLine();

        $this->assertEquals(146, mb_strlen($line));
    }
}
