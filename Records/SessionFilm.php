<?php

namespace NumaxLab\Icaa\Records;

use Assert\Assert;
use Carbon\Carbon;
use Stringy\Stringy;

class SessionFilm implements RecordInterface
{
    const RECORD_TYPE = 3;

    /**
     * @var string
     */
    private $cinemaTheatreCode;

    /**
     * @var Carbon
     */
    private $sessionOccurredOn;

    /**
     * @var int
     */
    private $filmId;

    /**
     * SessionFilm constructor.
     * @param string $cinemaTheatreCode
     * @param Carbon $sessionOccurredOn
     * @param int $filmId
     */
    public function __construct($cinemaTheatreCode, Carbon $sessionOccurredOn, $filmId)
    {
        $this->setCinemaTheatreCode($cinemaTheatreCode);
        $this->setSessionOccurredOn($sessionOccurredOn);
        $this->setFilmId($filmId);
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
     * @param Carbon $sessionOccurredOn
     */
    private function setSessionOccurredOn(Carbon $sessionOccurredOn)
    {
        $this->sessionOccurredOn = $sessionOccurredOn;
    }

    /**
     * @param int $filmId
     */
    private function setFilmId($filmId)
    {
        Assert::that($filmId)
            ->integer()
            ->greaterThan(0);

        $this->filmId = $filmId;
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
    public function getSessionOccurredOn()
    {
        return $this->sessionOccurredOn;
    }

    /**
     * @return int
     */
    public function getFilmId()
    {
        return $this->filmId;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= Stringy::create($this->getCinemaTheatreCode())->padRight(12, ' ');
        $line .= $this->getSessionOccurredOn()->format('dmy');
        $line .= $this->getSessionOccurredOn()->format('Hi');
        $line .= Stringy::create($this->getFilmId())->padLeft(5, '0');

        return $line;
    }

    /**
     * @param string $line
     * @return SessionFilm
     */
    public static function fromLine($line)
    {
        $cinemaTheatreCode = (string) Stringy::create($line)->substr(1, 12)->trimRight();
        $sessionOccurredOn = Carbon::createFromFormat(
            'dmyHi',
            (string) Stringy::create($line)->substr(13, 10)
        );
        $filmId = (int)(string) Stringy::create($line)->substr(23, 5)->trimLeft('0');

        return new self($cinemaTheatreCode, $sessionOccurredOn, $filmId);
    }
}
