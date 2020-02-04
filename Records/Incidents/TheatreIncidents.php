<?php

namespace NumaxLab\Icaa\Records\Incidents;

use Assert\Assert;
use NumaxLab\Icaa\Records\RecordInterface;
use Stringy\Stringy;

class TheatreIncidents implements RecordInterface
{
    const RECORD_TYPE = 1;

    /**
     * @var string
     */
    private $theatreCode;

    /**
     * @var boolean
     */
    private $monday;

    /**
     * @var boolean
     */
    private $tuesday;

    /**
     * @var boolean
     */
    private $wednesday;

    /**
     * @var boolean
     */
    private $thursday;

    /**
     * @var boolean
     */
    private $friday;

    /**
     * @var boolean
     */
    private $saturday;

    /**
     * @var boolean
     */
    private $sunday;

    /**
     * @var string|null
     */
    private $comments;

    /**
     * TheatreIncident constructor.
     * @param string $theatreCode
     * @param bool $monday
     * @param bool $tuesday
     * @param bool $wednesday
     * @param bool $thursday
     * @param bool $friday
     * @param bool $saturday
     * @param bool $sunday
     * @param string|null $comments
     */
    public function __construct(
        $theatreCode,
        $monday,
        $tuesday,
        $wednesday,
        $thursday,
        $friday,
        $saturday,
        $sunday,
        $comments = null
    ) {
        $this->setTheatreCode($theatreCode);
        $this->monday = $monday;
        $this->tuesday = $tuesday;
        $this->wednesday = $wednesday;
        $this->thursday = $thursday;
        $this->friday = $friday;
        $this->saturday = $saturday;
        $this->sunday = $sunday;
        $this->setComments($comments);
    }

    /**
     * @param string $theatreCode
     */
    private function setTheatreCode($theatreCode)
    {
        Assert::that($theatreCode)
            ->notEmpty()
            ->length(6);

        $this->theatreCode = $theatreCode;
    }

    /**
     * @param string|null $comments
     */
    private function setComments($comments)
    {
        if ($comments !== null) {
            Assert::that($comments)
                ->maxLength(79);

            $this->comments = $comments;
        }
    }

    /**
     * @return string
     */
    public function getTheatreCode()
    {
        return $this->theatreCode;
    }

    /**
     * @return bool
     */
    public function hasOnMonday()
    {
        return $this->monday;
    }

    /**
     * @return bool
     */
    public function hasOnTuesday()
    {
        return $this->tuesday;
    }

    /**
     * @return bool
     */
    public function hasOnWednesday()
    {
        return $this->wednesday;
    }

    /**
     * @return bool
     */
    public function hasOnThursday()
    {
        return $this->thursday;
    }

    /**
     * @return bool
     */
    public function hasOnFriday()
    {
        return $this->friday;
    }

    /**
     * @return bool
     */
    public function hasOnSaturday()
    {
        return $this->saturday;
    }

    /**
     * @return bool
     */
    public function hasOnSunday()
    {
        return $this->sunday;
    }

    /**
     * @return string|null
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @return string
     */
    public function toLine()
    {
        $line = (string) self::RECORD_TYPE;
        $line .= Stringy::create($this->getTheatreCode())->padRight(12, ' ');
        $line .= $this->hasOnMonday() ? '1' : '0';
        $line .= $this->hasOnTuesday() ? '1' : '0';
        $line .= $this->hasOnWednesday() ? '1' : '0';
        $line .= $this->hasOnThursday() ? '1' : '0';
        $line .= $this->hasOnFriday() ? '1' : '0';
        $line .= $this->hasOnSaturday() ? '1' : '0';
        $line .= $this->hasOnSunday() ? '1' : '0';
        $line .= $this->getComments();

        return $line;
    }

    /**
     * @param string $line
     * @return TheatreIncidents
     */
    public static function fromLine($line)
    {
        $theatreCode = (string) Stringy::create($line)->substr(1, 12)->trimRight();
        $monday = (bool) Stringy::create($line)->substr(13, 1);
        $tuesday = (bool) Stringy::create($line)->substr(14, 1);
        $wednesday = (bool) Stringy::create($line)->substr(15, 1);
        $thursday = (bool) Stringy::create($line)->substr(16, 1);
        $friday = (bool) Stringy::create($line)->substr(17, 1);
        $saturday = (bool) Stringy::create($line)->substr(18, 1);
        $sunday = (bool) Stringy::create($line)->substr(19, 1);
        $comments = (string) Stringy::create($line)->substr(20)->trimRight();

        return new self(
            $theatreCode,
            $monday,
            $tuesday,
            $wednesday,
            $thursday,
            $friday,
            $saturday,
            $sunday,
            $comments
        );
    }
}
