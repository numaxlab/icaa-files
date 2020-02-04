<?php

namespace NumaxLab\Icaa\Files\Incidents;

use NumaxLab\Icaa\Files\DumperInterface;
use NumaxLab\Icaa\IncidentsFile;

class Dumper implements DumperInterface
{
    /**
     * @var string
     */
    private $endOfLine;

    /**
     * @var IncidentsFile
     */
    private $file;

    /**
     * Dumper constructor.
     * @param string $eol
     * @param IncidentsFile $file
     */
    public function __construct($eol, IncidentsFile $file)
    {
        $this->endOfLine = $eol;
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function dump()
    {
        $dump = $this->file->header()->toLine().$this->endOfLine;

        foreach ($this->file->theatresIncidents() as $theatreIncidents) {
            $dump .= $theatreIncidents->toLine().$this->endOfLine;
        }

        return utf8_decode($dump);
    }
}
