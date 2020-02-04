<?php

namespace NumaxLab\Icaa;

use Assert\Assertion;
use NumaxLab\Icaa\Files\Incidents\Dumper;
use NumaxLab\Icaa\Records\Collection;
use NumaxLab\Icaa\Records\Incidents\Header;
use NumaxLab\Icaa\Records\Incidents\TheatreIncidents;

class IncidentsFile
{
    public const EOL = "\r\n";

    /**
     * @var Header
     */
    private $header;

    /**
     * @var Collection
     */
    private $theatresIncidents;

    /**
     * IncidentsFile constructor.
     * @throws Exceptions\RecordsCollectionException
     */
    public function __construct()
    {
        $this->theatresIncidents = new Collection();
    }

    /**
     * @param Header $header
     * @return $this
     */
    public function setHeader(Header $header): self
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @param TheatreIncidents $theatreIncidents
     * @return $this
     */
    public function addTheatreIncidents(TheatreIncidents $theatreIncidents): self
    {
        $this->theatresIncidents->push($theatreIncidents);

        return $this;
    }

    /**
     * @return Header
     */
    public function header(): Header
    {
        return $this->header;
    }

    /**
     * @return Collection
     */
    public function theatresIncidents(): Collection
    {
        return $this->theatresIncidents;
    }

    /**
     * @param string $input
     * @param string $eol
     */
    public static function parse(string $input, string $eol = self::EOL): void
    {
        //
    }

    /**
     * @param string $eol
     * @return string
     * @throws \Assert\AssertionFailedException
     */
    public function dump(string $eol = self::EOL): string
    {
        $this->assertProperties();

        $dumper = new Dumper($eol, $this);

        return $dumper->dump();
    }

    /**
     * @throws \Assert\AssertionFailedException
     */
    private function assertProperties(): void
    {
        Assertion::notEmpty($this->header);
        Assertion::greaterThan($this->theatresIncidents()->count(), 0);
    }
}
