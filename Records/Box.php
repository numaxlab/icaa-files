<?php

namespace NumaxLab\Icaa\Records;

use Assert\Assert;
use Assert\Assertion;
use Carbon\Carbon;
use Stringy\Stringy;

class Box implements RecordInterface
{
    const RECORD_TYPE = 0;
    const FILE_TYPE_REGULAR = 'FL';
    const FILE_TYPE_DELAYED = 'AT';

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $fileType;

    /**
     * @var Carbon
     */
    private $lastScheduledFileSentAt;

    /**
     * @var Carbon
     */
    private $currentFileSentAt;

    /**
     * @var int
     */
    private $fileLinesQty;

    /**
     * @var int
     */
    private $sessionsQty;

    /**
     * @var int
     */
    private $ticketsQty;

    /**
     * @var float
     */
    private $earnings;

    /**
     * Box constructor.
     * @param string $fileType
     * @param string $code
     * @param Carbon $lastScheduledFileSentAt
     * @param Carbon $currentFileSentAt
     */
    public function __construct(
        $fileType,
        $code,
        Carbon $lastScheduledFileSentAt,
        Carbon $currentFileSentAt
    )
    {
        $this->setFileType($fileType);
        $this->setCode($code);
        $this->setLastScheduledFileSentAt($lastScheduledFileSentAt);
        $this->setCurrentFileSentAt($currentFileSentAt);
        $this->setFileLinesQty(0);
        $this->setSessionsQty(0);
        $this->setTicketsQty(0);
        $this->setEarnings(0.0);
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
     * @param $fileType
     */
    private function setFileType($fileType)
    {
        Assertion::inArray(
            $fileType,
            [
                self::FILE_TYPE_REGULAR,
                self::FILE_TYPE_DELAYED
            ]
        );

        $this->fileType = $fileType;
    }

    /**
     * @param Carbon $lastScheduledFileSentAt
     */
    private function setLastScheduledFileSentAt(Carbon $lastScheduledFileSentAt)
    {
        $this->lastScheduledFileSentAt = $lastScheduledFileSentAt;
    }

    /**
     * @param Carbon $currentFileSentAt
     */
    private function setCurrentFileSentAt(Carbon $currentFileSentAt)
    {
        Assertion::greaterOrEqualThan(
            $currentFileSentAt->getTimestamp(),
            $this->getLastScheduledFileSentAt()->getTimestamp()
        );

        $this->currentFileSentAt = $currentFileSentAt;
    }

    /**
     * @param int $fileLinesQty
     * @return Box
     */
    public function setFileLinesQty($fileLinesQty)
    {
        Assertion::integer($fileLinesQty);

        $this->fileLinesQty = $fileLinesQty;
        return $this;
    }

    /**
     * @param int $sessionsQty
     * @return Box
     */
    public function setSessionsQty($sessionsQty)
    {
        Assertion::integer($sessionsQty);

        $this->sessionsQty = $sessionsQty;
        return $this;
    }

    /**
     * @param int $ticketsQty
     * @return Box
     */
    public function setTicketsQty($ticketsQty)
    {
        Assertion::integer($ticketsQty);

        $this->ticketsQty = $ticketsQty;
        return $this;
    }

    /**
     * @param float $earnings
     * @return Box
     */
    public function setEarnings($earnings)
    {
        Assertion::float($earnings);

        $this->earnings = $earnings;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @return Carbon
     */
    public function getLastScheduledFileSentAt()
    {
        return $this->lastScheduledFileSentAt;
    }

    /**
     * @return Carbon
     */
    public function getCurrentFileSentAt()
    {
        return $this->currentFileSentAt;
    }

    /**
     * @return int
     */
    public function getFileLinesQty()
    {
        return $this->fileLinesQty;
    }

    /**
     * @return int
     */
    public function getSessionsQty()
    {
        return $this->sessionsQty;
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
    public function toLine()
    {
        $firstDayOfYear = Carbon::createFromDate(Carbon::now()->year, 1, 1);

        $line = (string) self::RECORD_TYPE;
        $line .= $this->getCode();
        $line .= $this->getFileType();
        $line .= Stringy::create((string) $firstDayOfYear->diffInDays($this->getLastScheduledFileSentAt()))
            ->padLeft(3, '0');
        $line .= Stringy::create((string) $firstDayOfYear->diffInDays($this->getCurrentFileSentAt()))
            ->padLeft(3, '0');
        $line .= Stringy::create((string) $this->getFileLinesQty())->padLeft(11, '0');
        $line .= Stringy::create((string) $this->getSessionsQty())->padLeft(11, '0');
        $line .= Stringy::create((string) $this->getTicketsQty())->padLeft(11, '0');
        $line .= Stringy::create(number_format($this->getEarnings(), 2, '.', ''))
            ->padLeft(11, '0');

        return $line;
    }

    /**
     * @param string $line
     * @return Box
     */
    public static function fromLine($line)
    {
        $firstDayOfYear = Carbon::createFromDate(Carbon::now()->year, 1, 1);

        $code = (string) Stringy::create($line)->substr(1, 3);
        $fileType = (string) Stringy::create($line)->substr(4, 2);

        $lastScheduledFileSentAtJulianDay = (int)(string) Stringy::create($line)->substr(6, 3)
            ->trimLeft('0');
        $lastScheduledFileSentAt = clone $firstDayOfYear->addDays($lastScheduledFileSentAtJulianDay);

        $currentFileSentAtJulianDay = (int)(string) Stringy::create($line)->substr(9, 3)
            ->trimLeft('0');
        $currentFileSentAt = clone $firstDayOfYear->addDays($currentFileSentAtJulianDay);

        $self = new self(
            $fileType,
            $code,
            $lastScheduledFileSentAt,
            $currentFileSentAt
        );

        $self->setFileLinesQty((int)(string) Stringy::create($line)->substr(12, 11)->trimLeft('0'));
        $self->setSessionsQty((int)(string) Stringy::create($line)->substr(23, 11)->trimLeft('0'));
        $self->setTicketsQty((int)(string) Stringy::create($line)->substr(34, 11)->trimLeft('0'));
        $self->setEarnings((float)(string) Stringy::create($line)->substr(45, 11)->trimLeft('0'));

        return $self;
    }
}
