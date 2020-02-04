<?php

namespace NumaxLab\Icaa\Records\Earnings;

use Assert\Assert;
use Carbon\Carbon;
use NumaxLab\Icaa\Records\RecordInterface;
use Stringy\Stringy;

class Session implements RecordInterface
{
    const RECORD_TYPE = 2;

    /**
     * @var string
     */
    private $cinemaTheatreCode;

    /**
     * @var Carbon
     */
    private $occurredOn;

    /**
     * @var int
     */
    private $filmsQty;

    /**
     * @var int
     */
    private $ticketsQty;

    /**
     * @var float
     */
    private $earnings;

    /**
     * @var string
     */
    private $incidentCode;

    /**
     * Session constructor.
     * @param string $cinemaTheatreCode
     * @param Carbon $occurredOn
     * @param int $filmsQty
     * @param int $ticketsQty
     * @param float $earnings
     * @param string $incidentCode
     */
    public function __construct(
        $cinemaTheatreCode,
        Carbon $occurredOn,
        $filmsQty,
        $ticketsQty,
        $earnings,
        $incidentCode
    )
    {
        $this->setCinemaTheatreCode($cinemaTheatreCode);
        $this->setOccurredOn($occurredOn);
        $this->setFilmsQty($filmsQty);
        $this->setTicketsQty($ticketsQty);
        $this->setEarnings($earnings);
        $this->setIncidentCode($incidentCode);
    }

    /**
     * @param string $cinemaTheatreCode
     */
    private function setCinemaTheatreCode($cinemaTheatreCode)
    {
        Assert::that($cinemaTheatreCode)
            ->notEmpty()
            ->length(6);

        $this->cinemaTheatreCode = $cinemaTheatreCode;
    }

    /**
     * @param Carbon $occurredOn
     */
    private function setOccurredOn(Carbon $occurredOn)
    {
        $this->occurredOn = $occurredOn;
    }

    /**
     * @param int $filmsQty
     */
    private function setFilmsQty($filmsQty)
    {
        Assert::that($filmsQty)
            ->integer()
            ->greaterThan(0);

        $this->filmsQty = $filmsQty;
    }

    /**
     * @param int $ticketsQty
     */
    private function setTicketsQty($ticketsQty)
    {
        Assert::that($ticketsQty)
            ->integer()
            ->greaterOrEqualThan(0);

        $this->ticketsQty = $ticketsQty;
    }

    /**
     * @param float $earnings
     */
    private function setEarnings($earnings)
    {
        Assert::that($earnings)
            ->float()
            ->greaterOrEqualThan(0);

        $this->earnings = $earnings;
    }

    /**
     * @param string $incidentCode
     * @return Session
     */
    private function setIncidentCode($incidentCode)
    {
        Assert::that($incidentCode)
            ->notEmpty()
            ->length(3);

        $this->incidentCode = $incidentCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCinemaTheatreCode()
    {
        return $this->cinemaTheatreCode;
    }

    /**
     * @return Carbon
     */
    public function getOccurredOn()
    {
        return $this->occurredOn;
    }

    /**
     * @return int
     */
    public function getFilmsQty()
    {
        return $this->filmsQty;
    }

    /**
     * @return int
     */
    public function getTicketsQty()
    {
        return $this->ticketsQty;
    }

    /**
     * @return float
     */
    public function getEarnings()
    {
        return $this->earnings;
    }

    /**
     * @return string
     */
    public function getIncidentCode()
    {
        return $this->incidentCode;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= Stringy::create($this->getCinemaTheatreCode())->padRight(12, ' ');
        $line .= $this->getOccurredOn()->format('dmy');
        $line .= $this->getOccurredOn()->format('Hi');
        $line .= Stringy::create((string) $this->getFilmsQty())->padLeft(2, '0');
        $line .= Stringy::create((string) $this->getTicketsQty())->padLeft(5, '0');
        $line .= Stringy::create(number_format($this->getEarnings(), 2, '.', ''))
            ->padLeft(8, '0');
        $line .= $this->getIncidentCode();

        return $line;
    }

    /**
     * @param string $line
     * @return Session
     */
    public static function fromLine($line)
    {
        $cinemaTheatreCode = (string) Stringy::create($line)->substr(1, 12)->trimRight();
        $occurredOn = Carbon::createFromFormat(
            'dmyHi',
            (string) Stringy::create($line)->substr(13, 10)
        );
        $filmsQty = (int)(string) Stringy::create($line)->substr(23, 2)->trimLeft('0');
        $ticketsQty = (int)(string) Stringy::create($line)->substr(25, 5)->trimLeft('0');
        $earnings = (float)(string) Stringy::create($line)->substr(30, 8)->trimLeft('0');
        $incidentCode = (string) Stringy::create($line)->substr(38, 3);

        return new self(
            $cinemaTheatreCode,
            $occurredOn,
            $filmsQty,
            $ticketsQty,
            $earnings,
            $incidentCode
        );
    }
}
