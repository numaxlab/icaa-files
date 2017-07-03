<?php

namespace NumaxLab\Icaa\Records;


use NumaxLab\Icaa\Exceptions\MissingPropertyException;

class SessionFilm implements RecordInterface
{
    const RECORD_TYPE = 3;

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
    private $filmId;

    /**
     * SessionFilm constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param string $cinemaTheatreCode
     * @return SessionFilm
     */
    public function setCinemaTheatreCode($cinemaTheatreCode)
    {
        $this->cinemaTheatreCode = $cinemaTheatreCode;
        return $this;
    }

    /**
     * @param \Carbon\Carbon $sessionDatetime
     * @return SessionFilm
     */
    public function setSessionDatetime($sessionDatetime)
    {
        $this->sessionDatetime = $sessionDatetime;
        return $this;
    }

    /**
     * @param int $filmId
     * @return SessionFilm
     */
    public function setFilmId($filmId)
    {
        $this->filmId = $filmId;
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
    public function getFilmId()
    {
        return $this->filmId;
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
        if (! $throwException && is_null($this->getSessionDatetime())) {
            $throwException = true;
            $missingProperty = 'sessionDatetime';
        }
        if (! $throwException && is_null($this->getFilmId())) {
            $throwException = true;
            $missingProperty = 'filmId';
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
        $line .= $this->getSessionDatetime()->format('dmy');
        $line .= $this->getSessionDatetime()->format('Hi');
        $line .= str_pad($this->getFilmId(), 5, '0', STR_PAD_LEFT);

        return $line;
    }
}
