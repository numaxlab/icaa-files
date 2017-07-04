<?php

namespace NumaxLab\Icaa\Records;


use Carbon\Carbon;
use NumaxLab\Icaa\Exceptions\MissingPropertyException;

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
        if (! $throwException && is_null($this->getSessionsQty())) {
            $throwException = true;
            $missingProperty = 'sessionsQty';
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
        $line .= str_pad((string) $this->getSessionsQty(), 2, '0');

        return $line;
    }

    /**
     * @param string $line
     * @return \NumaxLab\Icaa\Records\SessionScheduling
     */
    public static function fromLine($line)
    {
        $self = new self();

        $self->setCinemaTheatreCode(rtrim(substr($line, 1, 12)));
        $self->setSessionDatetime(Carbon::createFromFormat('dmy', substr($line, 13, 6)));
        $self->setSessionsQty((int) ltrim(substr($line, 19, 2), '0'));

        return $self;
    }
}
