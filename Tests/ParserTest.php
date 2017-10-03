<?php

namespace NumaxLab\Icaa\Tests;

use NumaxLab\Icaa\IcaaFile;
use NumaxLab\Icaa\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParsesFile()
    {
        $fileContent = file_get_contents(__DIR__.'/Fixtures/fixture01');

        $parser = new Parser(PHP_EOL, new IcaaFile());

        $icaaFile = $parser->parse($fileContent);

        $this->assertInstanceOf(IcaaFile::class, $icaaFile);
    }
}
