<?php

namespace NumaxLab\Icaa\Records\Earnings;

use Assert\Assert;
use Carbon\Carbon;
use NumaxLab\Icaa\Records\RecordInterface;
use Stringy\Stringy;

class SessionScheduling implements RecordInterface
{
    const RECORD_TYPE = 5;

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
    private $sessionsQty;

    /**
     * SessionScheduling constructor.
     * @param string $cinemaTheatreCode
     * @param Carbon $sessionOccurredOn
     * @param int $sessionsQty
     */
    public function __construct($cinemaTheatreCode, Carbon $sessionOccurredOn, $sessionsQty)
    {
        $this->setCinemaTheatreCode($cinemaTheatreCode);
        $this->setSessionOccurredOn($sessionOccurredOn);
        $this->setSessionsQty($sessionsQty);
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
     * @param int $sessionsQty
     */
    private function setSessionsQty($sessionsQty)
    {
        Assert::that($sessionsQty)
            ->integer()
            ->greaterOrEqualThan(0);

        $this->sessionsQty = $sessionsQty;
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
        $line .= Stringy::create($this->getCinemaTheatreCode())->padRight(12, ' ');
        $line .= $this->getSessionOccurredOn()->format('dmy');
        $line .= Stringy::create($this->getSessionsQty())->padLeft(2, '0');

        return $line;
    }

    /**
     * @param string $line
     * @return SessionScheduling
     */
    public static function fromLine($line)
    {
        $cinemaTheatreCode = (string) Stringy::create($line)->substr(1, 12)->trimRight();
        $sessionOccurredOn = Carbon::createFromFormat(
            'dmy',
            (string) Stringy::create($line)->substr(13, 6)
        );
        $sessionsQty = (int)(string) Stringy::create($line)->substr(19, 2)->trimLeft('0');

        return new self(
            $cinemaTheatreCode,
            $sessionOccurredOn,
            $sessionsQty
        );
    }
}
