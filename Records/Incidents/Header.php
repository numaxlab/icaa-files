<?php

namespace NumaxLab\Icaa\Records\Incidents;

use Assert\Assert;
use Carbon\Carbon;
use NumaxLab\Icaa\Records\RecordInterface;
use Stringy\Stringy;

class Header implements RecordInterface
{
    const RECORD_TYPE = 0;

    /**
     * @var string
     */
    private $code;

    /**
     * @var Carbon
     */
    private $startDate;

    /**
     * @var Carbon
     */
    private $endDate;

    /**
     * Header constructor.
     * @param string $code
     * @param Carbon $startDate
     * @param Carbon $endDate
     */
    public function __construct($code, Carbon $startDate, Carbon $endDate)
    {
        $this->setCode($code);
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @param string $code
     */
    private function setCode($code)
    {
        Assert::that($code)
            ->notEmpty()
            ->length(3);

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return Carbon
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return Carbon
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= $this->getCode();
        $line .= $this->getStartDate()->format('dmy');
        $line .= $this->getEndDate()->format('dmy');

        return $line;
    }

    /**
     * @param string $line
     * @return Header
     */
    public static function fromLine($line)
    {
        $code = (string) Stringy::create($line)->substr(1, 3);
        $startDate = Carbon::createFromFormat(
            'dmy',
            Stringy::create($line)->substr(4, 9)
        );
        $endDate = Carbon::createFromFormat(
            'dmy',
            Stringy::create($line)->substr(10, 15)
        );

        return new self(
            $code,
            $startDate,
            $endDate
        );
    }
}
