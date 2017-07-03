<?php

namespace NumaxLab\Icaa\Records;


class SessionScheduling implements RecordInterface
{
    const RECORD_TYPE = 5;

    /**
     * @var string
     */
    private $cinemaTheatreCode;

    /**
     * @var \Carbon\Carbon
     */
    private $sessionDatetime;

    /**
     * @var int
     */
    private $sessionsQty;

    /**
     * SessionScheduling constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param string $cinemaTheatreCode
     * @return SessionScheduling
     */
    public function setCinemaTheatreCode($cinemaTheatreCode)
    {
        $this->cinemaTheatreCode = $cinemaTheatreCode;
        return $this;
    }

    /**
     * @param \Carbon\Carbon $sessionDatetime
     * @return SessionScheduling
     */
    public function setSessionDatetime($sessionDatetime)
    {
        $this->sessionDatetime = $sessionDatetime;
        return $this;
    }

    /**
     * @param int $sessionsQty
     * @return SessionScheduling
     */
    public function setSessionsQty($sessionsQty)
    {
        $this->sessionsQty = $sessionsQty;
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
    public function getSessionDatetime()
    {
        return $this->sessionDatetime;
    }

    /**
     * @return int
     */
    public function getSessionsQty()
    {
        return $this->sessionsQty;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= str_pad($this->getCinemaTheatreCode(), 12, ' ');
        $line .= $this->getSessionDatetime()->format('dmy');
        $line .= str_pad((string) $this->getSessionsQty(), 2, '0');

        return $line;
    }
}
