<?php

namespace NumaxLab\Icaa\Records;

class Session implements RecordInterface
{
    const RECORD_TYPE = 2;

    /**
     * @var string
     */
    private $cinemaTheatreCode;

    /**
     * @var \Carbon\Carbon
     */
    private $datetime;

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
     */
    public function __construct()
    {

    }

    /**
     * @param string $cinemaTheatreCode
     * @return Session
     */
    public function setCinemaTheatreCode($cinemaTheatreCode)
    {
        $this->cinemaTheatreCode = $cinemaTheatreCode;
        return $this;
    }

    /**
     * @param \Carbon\Carbon $datetime
     * @return Session
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    /**
     * @param int $filmsQty
     * @return Session
     */
    public function setFilmsQty($filmsQty)
    {
        $this->filmsQty = $filmsQty;
        return $this;
    }

    /**
     * @param int $ticketsQty
     * @return Session
     */
    public function setTicketsQty($ticketsQty)
    {
        $this->ticketsQty = $ticketsQty;
        return $this;
    }

    /**
     * @param float $earnings
     * @return Session
     */
    public function setEarnings($earnings)
    {
        $this->earnings = $earnings;
        return $this;
    }

    /**
     * @param string $incidentCode
     * @return Session
     */
    public function setIncidentCode($incidentCode)
    {
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
     * @return \Carbon\Carbon
     */
    public function getDatetime()
    {
        return $this->datetime;
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
        $line .= str_pad($this->getCinemaTheatreCode(), 12, ' ');
        $line .= $this->getDatetime()->format('dmy');
        $line .= $this->getDatetime()->format('Hi');
        $line .= str_pad((string) $this->getFilmsQty(), 2, '0', STR_PAD_LEFT);
        $line .= str_pad((string) $this->getTicketsQty(), 5, '0', STR_PAD_LEFT);
        $line .= str_pad(
            (string) number_format($this->getEarnings(), 2, '.', ''),
            8,
            '0',
            STR_PAD_LEFT
        );
        $line .= $this->getIncidentCode();

        return $line;
    }
}
