<?php

namespace NumaxLab\Icaa\Records;

use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;

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
    public function setDatetime(Carbon $datetime)
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
     * @throws \NumaxLab\Icaa\Exceptions\MissingPropertyException
     */
    private function checkProperties()
    {
        $throwException = false;
        $missingProperty = '';

        if (is_null($this->getCinemaTheatreCode())) {
            $throwException = true;
            $missingProperty = 'cinemaTheatreCode';
        }
        if (! $throwException && is_null($this->getDatetime())) {
            $throwException = true;
            $missingProperty = 'datetime';
        }
        if (! $throwException && is_null($this->getFilmsQty())) {
            $throwException = true;
            $missingProperty = 'filmsQty';
        }
        if (! $throwException && is_null($this->getTicketsQty())) {
            $throwException = true;
            $missingProperty = 'ticketsQty';
        }
        if (! $throwException && is_null($this->getEarnings())) {
            $throwException = true;
            $missingProperty = 'earnings';
        }
        if (! $throwException && is_null($this->getIncidentCode())) {
            $throwException = true;
            $missingProperty = 'incidentCode';
        }

        if ($throwException) {
            throw new MissingPropertyException(sprintf("Missing property %s", $missingProperty));
        }
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $this->checkProperties();

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

    /**
     * @param string $line
     * @return \NumaxLab\Icaa\Records\Session
     */
    public static function fromLine($line)
    {
        return new self();
    }
}
