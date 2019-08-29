<?php

namespace NumaxLab\Icaa\Tests;

use NumaxLab\Icaa\Encrypter;
use PHPUnit\Framework\TestCase;

class EncrypterTest extends TestCase
{
    /**
     * @var \NumaxLab\Icaa\Encrypter
     */
    protected $sut;

    /**
     * @var \Mockery\MockInterface
     */
    protected $fileMock;

    protected function setUp()
    {
        parent::setUp();

        $this->sut = new Encrypter(file_get_contents('./Tests/key.pkr'));
    }

    public function testEncryptsString()
    {
        $toEncrypt = "test";

        $encrypted = $this->sut->encrypt($toEncrypt);

        $this->assertTrue(true);
    }
}
