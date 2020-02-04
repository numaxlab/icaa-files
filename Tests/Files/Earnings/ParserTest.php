<?php

namespace NumaxLab\Icaa\Tests;

use NumaxLab\Icaa\EarningsFile;
use NumaxLab\Icaa\Files\Earnings\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParsesFile()
    {
        $fileContent = file_get_contents(__DIR__ . '/../../Fixtures/fixture01');

        $parser = new Parser(PHP_EOL, new EarningsFile());

        $icaaFile = $parser->parse($fileContent);

        $this->assertInstanceOf(EarningsFile::class, $icaaFile);
    }
}
